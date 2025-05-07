<?php

namespace Fintech\Auth\Services;

use ErrorException;
use Exception;
use Fintech\Auth\Events\Attempting;
use Fintech\Auth\Events\Authenticated;
use Fintech\Auth\Events\Failed;
use Fintech\Auth\Events\Forbidden;
use Fintech\Auth\Events\Frozen;
use Fintech\Auth\Events\LoggedOut;
use Fintech\Auth\Exceptions\AccessForbiddenException;
use Fintech\Auth\Exceptions\AccountFrozenException;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Interfaces\ProfileRepository;
use Fintech\Auth\Interfaces\UserRepository;
use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Enums\Auth\LoginStatus;
use Fintech\Core\Enums\Auth\PasswordResetOption;
use Fintech\Core\Enums\Auth\UserStatus;
use Fintech\Core\Enums\RequestPlatform;
use Fintech\Core\Traits\HasFindWhereSearch;
use Fintech\MetaData\Facades\MetaData;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDOException;
use stdClass;

/**
 * Class UserService
 *
 */
class UserService
{
    use HasFindWhereSearch;

    private array $loginAttempt;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ProfileRepository $profileRepository
     */
    public function __construct(
        private readonly UserRepository    $userRepository,
        private readonly ProfileRepository $profileRepository
    ) {
        $this->loginAttempt = [];
    }

    public function destroy($id)
    {
        return ($this->userRepository->delete($id) && $this->profileRepository->delete($id));
    }

    public function restore($id)
    {
        return ($this->userRepository->restore($id) && $this->profileRepository->restore($id));
    }

    public function export(array $filters)
    {
        return $this->userRepository->list($filters);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->userRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->userRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        DB::beginTransaction();

        try {
            $userData = $this->formatDataFromInput($inputs, true);

            if ($user = $this->userRepository->create($userData)) {

                DB::commit();

                return $user;
            }

            return null;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new PDOException($exception->getMessage(), 0, $exception);
        }
    }

    private function formatDataFromInput($inputs, bool $forCreate = false)
    {
        $data = $inputs;

        if ($forCreate) {
            $data['password'] = Hash::make(($inputs['password'] ?? config('fintech.auth.default_password', '123456')));
            $data['pin'] = Hash::make(($inputs['pin'] ?? config('fintech.auth.default_pin', '123456')));
        } else {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            if (!empty($data['pin'])) {
                $data['pin'] = Hash::make($data['pin']);
            } else {
                unset($data['pin']);
            }
        }

        $data['roles'] = $inputs['roles'] ?? config('fintech.auth.customer_roles', []);

        $data['status'] = $data['status'] ?? UserStatus::Registered->value;

        return $data;
    }

    /**
     * @throws ErrorException
     */
    public function updateFromAdmin($id, array $inputs = [])
    {
        DB::beginTransaction();

        try {
            $userData = $this->formatDataFromInput($inputs);

            if ($user = $this->userRepository->update($id, $userData)) {

                DB::commit();

                return $user;
            }

            return null;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new ErrorException($exception->getMessage(), 0, $exception);
        }
    }

    /**
     * @throws ErrorException
     */
    public function update($id, array $inputs = [])
    {
        DB::beginTransaction();

        try {

            if (isset($inputs['password'])) {
                $inputs['password'] = Hash::make($inputs['password']);
            }

            if (isset($inputs['pin'])) {
                $inputs['pin'] = Hash::make($inputs['pin']);
            }


            if ($user = $this->userRepository->update($id, $inputs)) {

                DB::commit();

                return $user;
            }

            return null;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new ErrorException($exception->getMessage(), 0, $exception);
        }
    }

    /**
     * @throws Exception
     */
    public function reset($user, $field)
    {

        Config::set('fintech.auth.password_reset_method', PasswordResetOption::TemporaryPassword->value);

        if ($field == 'pin') {

            $response = Auth::pinReset()->notifyUser($user);

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            return $response;
        }

        if ($field == 'password') {

            $response = Auth::passwordReset()->notifyUser($user);

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            return $response;
        }

        if ($field == 'both') {

            $pinResponse = Auth::pinReset()->notifyUser($user);
            $passwordResponse = Auth::passwordReset()->notifyUser($user);

            if (!$pinResponse['status'] || !$passwordResponse['status']) {
                throw new Exception("Failed");
            }

            return ['status' => true, 'message' => "{$pinResponse['messages']} {$passwordResponse['message']}"];

        }

        return ['status' => false, 'message' => 'No Action Selected'];

    }

    /**
     * @param array $inputs
     * @param string $guard
     * @return BaseModel|\Fintech\Auth\Models\User|User|null
     * @throws Exception
     */
    public function login(array $inputs, string $guard = 'web')
    {
        $passwordField = config('fintech.auth.password_field', 'password');

        $fcmToken = $inputs['fcm_token'] ?? null;

        $password = null;

        if (isset($inputs[$passwordField])) {
            $password = $inputs[$passwordField];
            unset($inputs[$passwordField]);
        }

        $attemptUser = $this->list($inputs);

        if ($attemptUser->isEmpty()) {

            if (config('fintech.auth.record_login_attempt')) {

                Auth::loginAttempt()->create($this->loginAttemptData(null, LoginStatus::Invalid, __('auth::messages.failed')));
            }

            event(new Attempting($inputs, false));

            throw new Exception(__('auth::messages.failed'));
        }

        /**
         * @var \Fintech\Auth\Models\User $attemptUser
         */
        $attemptUser = $attemptUser->first();

        if ($attemptUser->wrong_password > config('fintech.auth.password_threshold', 10)) {

            $this->userRepository->update($attemptUser->getKey(), [
                'status' => UserStatus::Suspended->value,
            ]);

            if (config('fintech.auth.record_login_attempt')) {

                Auth::loginAttempt()->create($this->loginAttemptData($attemptUser->getKey(), LoginStatus::Banned, __('auth::messages.lockup')));
            }

            event(new Frozen($attemptUser));

            throw new AccountFrozenException(__('auth::messages.lockup'));
        }

        if (!Hash::check($password, $attemptUser->{$passwordField})) {

            $wrongPasswordCount = $attemptUser->wrong_password + 1;

            $this->userRepository->update($attemptUser->getKey(), [
                'wrong_password' => $wrongPasswordCount,
            ]);

            if (config('fintech.auth.record_login_attempt')) {

                Auth::loginAttempt()->create(
                    $this->loginAttemptData(
                        $attemptUser->getKey(),
                        LoginStatus::Failed,
                        __(
                            'auth::messages.warning',
                            ['attempt' => $wrongPasswordCount, 'threshold' => config('fintech.auth.threshold.password', 10)]
                        )
                    )
                );

            }

            event(new Failed($attemptUser, $inputs));

            throw new Exception(__('auth::messages.warning', [
                'attempt' => $wrongPasswordCount,
                'threshold' => config('fintech.auth.threshold.password', 10),
            ]));
        }

        \Illuminate\Support\Facades\Auth::guard($guard)->setUser($attemptUser);

        if ($attemptUser->tokens->isNotEmpty()) {

            $attemptUser->tokens->each(fn ($token) => $token->delete());
        }

        $platform = $inputs['platform'];

        $permissions = $this->platformLoginRequiredPermission($platform);

        if (!$attemptUser->can($permissions)) {

            if (config('fintech.auth.record_login_attempt')) {

                Auth::loginAttempt()->create(
                    $this->loginAttemptData(
                        $attemptUser->getKey(),
                        LoginStatus::Failed,
                        __(
                            'auth::messages.forbidden',
                            ['permission' => permission_format('auth.login', 'auth')]
                        )
                    )
                );
            }

            event(new Forbidden($attemptUser, $permissions));

            throw new AccessForbiddenException(__('auth::messages.forbidden', ['permission' => permission_format('auth.login', 'auth')]));
        }

        if (config('fintech.auth.record_login_attempt')) {

            Auth::loginAttempt()->create(
                $this->loginAttemptData(
                    $attemptUser->getKey(),
                    LoginStatus::Successful,
                    __('auth::messages.success')
                )
            );
        }

        if (!empty($fcmToken)) {
            $attemptUser = $this->userRepository->update($attemptUser->getKey(), [
                'fcm_token' => $fcmToken,
            ]);
        }

        event(new Authenticated($attemptUser));

        return $attemptUser;

    }

    private function loginAttemptData($user_id, $status, $note): array
    {
        if (empty($this->loginAttempt)) {

            $ip = request()->header('Agent-Id')
                ? long2ip(request()->header('Agent-Id'))
                : request()->ip();

            $ipAddress = Auth::geoip()->find($ip);

            $address = implode(', ', [
                $ipAddress['city'],
                $ipAddress['region_name'],
                $ipAddress['zip'],
                $ipAddress['country_name'],
                $ipAddress['continent_name']]);

            $country = MetaData::country()->findWhere(['iso2' => $ipAddress['country_code']]);
            $state = new stdClass();
            $city = new stdClass();

            if ($country) {
                $state = MetaData::state()->findWhere(['country_id' => $country->id, 'search' => $ipAddress['region_name']]);
                $query = ['country_id' => $country->id, 'search' => $ipAddress['city']];
                if ($state) {
                    $query['state_id'] = $state->id;
                }
                $city = MetaData::city()->findWhere($query);
                unset($query);
            }

            $headers = [];

            foreach (request()->headers->all() as $header => $value) {

                if ($header == 'authorization') {
                    continue;
                }

                $headers[$header] = ($header == 'attempt-data')
                    ? json_decode($value[0])
                    : $value[0];
            }

            $this->loginAttempt = [
                'ip' => $ip,
                'mac' => null,
                'agent' => request()->userAgent(),
                'platform' => request()->platform(),
                'address' => $address,
                'city' => $ipAddress['city'] ?? null,
                'city_id' => $city->id ?? null,
                'state' => $ipAddress['region_name'] ?? null,
                'state_id' => $state->id ?? null,
                'country' => $ipAddress['country_name'] ?? null,
                'country_id' => $country->id ?? null,
                'latitude' => $ipAddress['latitude'] ?? null,
                'longitude' => $ipAddress['longitude'] ?? null,
                'login_attempt_data' => [
                    'ipaddress' => $ipAddress,
                    'timestamp' => request()->header('Timestamp'),
                    'headers' => $headers,
                    'credentials' => request()->except(config('fintech.auth.password_field')),
                ],
            ];
        }

        $this->loginAttempt['user_id'] = $user_id;
        $this->loginAttempt['status'] = $status->value;
        $this->loginAttempt['note'] = $note;

        return $this->loginAttempt;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->userRepository->find($id, $onlyTrashed);
    }

    private function platformLoginRequiredPermission(RequestPlatform $platform): ?array
    {
        return match ($platform) {
            RequestPlatform::WebAgent => ['agent.login'],
            RequestPlatform::WebAdmin => ['admin.login'],
            default => ['customer.login'],
        };
    }

    public function logout(Request $request): bool
    {
        $user = $request->user('sanctum');

        event(new LoggedOut($user));

        $user->currentAccessToken()->delete();

        return true;

    }
}
