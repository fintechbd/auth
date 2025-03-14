<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Http\Requests\StoreSettingRequest;
use Fintech\Auth\Http\Resources\SettingResource;
use Fintech\Core\Facades\Core;
use Fintech\Core\Supports\Utility;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class SettingController
 *
 * @lrd:start
 * This class handle system setting related to individual user
 *
 * @lrd:end
 */
class SettingController extends Controller
{
    /**
     * @lrd:start
     * Return a listing of the settings in key and value format.
     * *`setting`* value depends on  number of package configured to system
     *
     * @lrd:end
     */
    public function index(): SettingResource|JsonResponse
    {
        try {

            $configurations = (Auth::check())
                ? Core::setting()->list(['user_id' => auth()->id()])
                : collect([]);

            $settings = [];

            $configurations->each(function ($setting) use (&$settings) {
                $settings[$setting->package][$setting->key] = Utility::typeCast($setting->value, $setting->type);
            });

            return new SettingResource($settings);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @LRDparam package string|required|in:dashboard,other
     *
     * @lrd:start
     * Update a specified user settings using configuration
     *
     * @lrd:end
     */
    public function store(StoreSettingRequest $request): JsonResponse
    {
        try {

            $configuration = $request->input('package', 'dashboard');

            $inputs = $request->except('package');

            foreach ($inputs as $key => $value) {
                Core::setting()->setValue($configuration, $key, $value, null, auth()->id());
            }

            cache()->forget('fintech.setting');

            return response()->updated(__('core::messages.setting.saved', ['package' => ucwords($configuration)]));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified setting resource using id.
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function destroy(string $configuration)
    {
        try {

            $settings = Core::setting()->list(['package' => $configuration]);

            foreach ($settings as $setting) {
                Core::setting()->destroy($setting->getKey());
            }

            return response()->deleted(__('core::messages.setting.deleted', ['model' => 'Setting']));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
