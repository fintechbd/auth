<?php

// config for fintech/auth
use Fintech\Auth\Models\Audit;
use Fintech\Auth\Models\Favourite;
use Fintech\Auth\Models\LoginAttempt;
use Fintech\Auth\Models\OneTimePin;
use Fintech\Auth\Models\Permission;
use Fintech\Auth\Models\Profile;
use Fintech\Auth\Models\Role;
use Fintech\Auth\Models\Team;
use Fintech\Auth\Models\User;
use Fintech\Auth\Repositories\Eloquent\AuditRepository;
use Fintech\Auth\Repositories\Eloquent\FavouriteRepository;
use Fintech\Auth\Repositories\Eloquent\LoginAttemptRepository;
use Fintech\Auth\Repositories\Eloquent\OneTimePinRepository;
use Fintech\Auth\Repositories\Eloquent\PermissionRepository;
use Fintech\Auth\Repositories\Eloquent\ProfileRepository;
use Fintech\Auth\Repositories\Eloquent\RoleRepository;
use Fintech\Auth\Repositories\Eloquent\TeamRepository;
use Fintech\Auth\Repositories\Eloquent\UserRepository;
use Fintech\Auth\Services\Vendors\GeoIp\Cloudflare;
use Fintech\Auth\Services\Vendors\GeoIp\Ip2Location;
use Fintech\Auth\Services\Vendors\GeoIp\IpApi;
use Fintech\Auth\Services\Vendors\GeoIp\IpData;
use Fintech\Auth\Services\Vendors\GeoIp\IpInfo;
use Fintech\Auth\Services\Vendors\GeoIp\Kloudend;
use Fintech\Auth\Services\Vendors\GeoIp\Local;
use Fintech\Auth\Services\Vendors\GeoIp\MaxMind;

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Module APIs
    |--------------------------------------------------------------------------
    | this setting enable the api will be available or not
    */
    'enabled' => env('PACKAGE_AUTH_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Auth Group Root Prefix
    |--------------------------------------------------------------------------
    |
    | This value will be added to your all routes from this package
    | Example: APP_URL/{root_prefix}/api/{version}/auth/action
    |
    | Note: while adding prefix add closing ending slash '/'
    */
    'root_prefix' => 'api/',

    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    | Exclude auth fields
    | Example: reset_link, otp, temporary_password
    */
    'self_password_reset' => true,
    'password_reset_method' => 'otp',
    'temporary_password_length' => 8,

    /*
    |--------------------------------------------------------------------------
    | Permission Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'permission_model' => Permission::class,

    /*
    |--------------------------------------------------------------------------
    | Role Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'role_model' => Role::class,
    'customer_roles' => [],

    /*
    |--------------------------------------------------------------------------
    | Team Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'team_model' => Team::class,

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'user_model' => User::class,

    /*
    |--------------------------------------------------------------------------
    | User Fallback Image Path
    |--------------------------------------------------------------------------
    |
    | This value should be relative to public directory.
    */
    'user_image' => '/vendor/auth/img/anonymous-user.png',

    /*
    |--------------------------------------------------------------------------
    | User Profile Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'profile_model' => Profile::class,

    /*
    |--------------------------------------------------------------------------
    | One Time Password/Pin Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'otp_model' => OneTimePin::class,
    'otp_length' => 4,
    //values 'otp' or 'link'
    'otp_method' => 'otp',

    /*
    |--------------------------------------------------------------------------
    | Audit Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'audit_model' => Audit::class,

    /*
    |--------------------------------------------------------------------------
    | Favourite Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'favourite_model' => Favourite::class,


    /*
    |--------------------------------------------------------------------------
    | LoginAttempt Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'login_attempt_model' => LoginAttempt::class,
    'record_login_attempt' => env('PACKAGE_AUTH_RECORD_LOGIN_ATTEMPT', false),
    /*
    |--------------------------------------------------------------------------
    | IP Analyze Drivers
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'geoip' => [
        'default' => env('PACKAGE_AUTH_GEOIP_DRIVER', null),
        'whitelist' => ['0.0.0.0', 'localhost', '192.168.10.115', '127.0.0.1'],
        'drivers' => [
            'local' => [
                'class' => Local::class,
                'type' => 'city',
                'path' => 'maxmind/GeoLite2-City.mmdb',
            ],
            'ipapi' => [
                'class' => IpApi::class,
                'token' => env('PACKAGE_AUTH_IPAPI_TOKEN'),
            ],
            'ipinfo' => [
                'class' => IpInfo::class,
                'token' => env('PACKAGE_AUTH_IPINFO_TOKEN'),
            ],
            'ipdata' => [
                'class' => IpData::class,
                'token' => env('PACKAGE_AUTH_IPDATA_TOKEN'),
            ],
            'ip2location' => [
                'class' => Ip2Location::class,
                'token' => env('PACKAGE_AUTH_IP2LOCATION_TOKEN'),
            ],
            'cloudflare' => [
                'class' => Cloudflare::class,
            ],
            'kloudend' => [
                'class' => Kloudend::class,
                'token' => env('PACKAGE_AUTH_KLOUDEND_TOKEN'),
            ],
            'maxmind' => [
                'class' => MaxMind::class,
                'user_id' => env('PACKAGE_AUTH_MAXMIND_USER_ID'),
                'license_key' => env('PACKAGE_AUTH_MAXMIND_LICENSE_KEY'),
                'options' => ['host' => 'geoip.maxmind.com'],
            ]
        ]
    ],

    //** Model Config Point Do not Remove **//

    /*
    |--------------------------------------------------------------------------
    | Auth Field Validation
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    | Example: login_id, email, mobile
    */
    'auth_field' => 'login_id',
    'auth_field_rules' => ['required', 'string', 'min:6', 'max:255'],

    /*
    |--------------------------------------------------------------------------
    | Pin Validation
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    | Example: login_id, email, mobile
    */
    'pin_field' => 'pin',
    'pin_field_rules' => ['required', 'string', 'min:6'],
    'default_pin' => '123456',
    'temporary_pin_length' => 5,

    /*
    |--------------------------------------------------------------------------
    | Password Validation
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    | Example: login_id, email, mobile
    */
    'password_field' => 'password',
    'password_field_rules' => ['string'],
    'default_password' => '12345678',

    /*
    |--------------------------------------------------------------------------
    | Login Validation
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    | Exclude auth fields
    */
    'register_rules' => [
        //user
        'name' => ['required', 'string', 'min:2', 'max:255'],
        'parent_id' => ['nullable', 'integer', 'min:1'],
        'mobile' => ['required', 'string', 'min:10'],
        'email' => ['required', 'string', 'email:rfc,dns', 'min:2', 'max:255'],
        'pin' => ['string', 'min:4', 'max:16'],
        'app_version' => ['nullable', 'string'],
        'fcm_token' => ['nullable', 'string'],
        'language' => ['nullable', 'string'],
        'currency' => ['nullable', 'string'],

        //profile
        'father_name' => ['string', 'nullable'],
        'mother_name' => ['string', 'nullable'],
        'gender' => ['string', 'nullable'],
        'marital_status' => ['string', 'nullable'],
        'occupation' => ['string', 'nullable'],
        'source_of_income' => ['string', 'nullable'],
        'id_type' => ['string', 'nullable'],
        'id_doc_type_id' => ['integer', 'required'],
        'id_no' => ['string', 'nullable'],
        'id_issue_country' => ['string', 'nullable'],
        'id_expired_at' => ['string', 'nullable'],
        'id_issue_at' => ['string', 'nullable'],
        'photo' => ['string', 'nullable'],
        'documents' => ['array', 'required', 'min:1'],
        'documents.*.type' => ['string', 'required'],
        'documents.*.back' => ['string', 'required_without:documents.*.front'],
        'documents.*.front' => ['string', 'required_without:documents.*.back'],
        'employer' => ['array', 'nullable'],
        'employer.employer_name' => ['string', 'nullable'],
        'employer.company_address' => ['string', 'nullable'],
        'employer.company_registration_number' => ['string', 'nullable'],
        'proof_of_address' => ['array'],
        'proof_of_address.*.type' => ['string', 'required'],
        'proof_of_address.*.back' => ['string', 'required_without:proof_of_address.*.front'],
        'proof_of_address.*.front' => ['string', 'required_without:proof_of_address.*.back'],
        'date_of_birth' => ['date', 'nullable'],
        'permanent_address' => ['string', 'nullable'],
        'permanent_city_id' => ['integer', 'nullable'],
        'permanent_state_id' => ['integer', 'nullable'],
        'permanent_country_id' => ['integer', 'nullable'],
        'permanent_post_code' => ['string', 'nullable'],
        'present_address' => ['string', 'nullable'],
        'present_city_id' => ['integer', 'nullable'],
        'present_state_id' => ['integer', 'nullable'],
        'present_country_id' => ['integer', 'nullable'],
        'present_post_code' => ['string', 'nullable'],
        'nationality' => ['string', 'nullable'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lock Up Threshold
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'password_threshold' => 10,
    'pin_threshold' => 3,
    'threshold_notification' => false,

    /*
    |--------------------------------------------------------------------------
    | Frontend Auth Routes
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'frontend_login_url' => env('FRONTEND_LOGIN_URL', env('APP_URL', '')),
    'frontend_reset_url' => env('FRONTEND_RESET_URL', env('APP_URL', '')),

    /*
    |--------------------------------------------------------------------------
    | Authentication Middlewares
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'middleware' => ['auth:sanctum'],

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'repositories' => [
        \Fintech\Auth\Interfaces\PermissionRepository::class => PermissionRepository::class,

        \Fintech\Auth\Interfaces\RoleRepository::class => RoleRepository::class,

        \Fintech\Auth\Interfaces\TeamRepository::class => TeamRepository::class,

        \Fintech\Auth\Interfaces\ProfileRepository::class => ProfileRepository::class,

        \Fintech\Auth\Interfaces\UserRepository::class => UserRepository::class,

        \Fintech\Auth\Interfaces\OneTimePinRepository::class => OneTimePinRepository::class,

        \Fintech\Auth\Interfaces\AuditRepository::class => AuditRepository::class,

        \Fintech\Auth\Interfaces\FavouriteRepository::class => FavouriteRepository::class,

        \Fintech\Auth\Interfaces\LoginAttemptRepository::class => LoginAttemptRepository::class,

        //** Repository Binding Config Point Do not Remove **//
    ],
];
