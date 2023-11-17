<?php

// config for fintech/auth
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
    'root_prefix' => '',

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
    'permission_model' => \Fintech\Auth\Models\Permission::class,

    /*
    |--------------------------------------------------------------------------
    | Role Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'role_model' => \Fintech\Auth\Models\Role::class,
    'customer_roles' => [],
    /*
    |--------------------------------------------------------------------------
    | Team Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'team_model' => \Fintech\Auth\Models\Team::class,

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'user_model' => \Fintech\Auth\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | User Profile Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'profile_model' => \Fintech\Auth\Models\Profile::class,

    /*
    |--------------------------------------------------------------------------
    | One Time Password/Pin Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'otp_model' => \Fintech\Auth\Models\OneTimePin::class,
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
    'audit_model' => \Fintech\Auth\Models\Audit::class,


    /*
    |--------------------------------------------------------------------------
    | IdDocType Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'id_doc_type_model' => \Fintech\Auth\Models\IdDocType::class,

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
    'password_field_rules' => ['string', 'min:8'],
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
        'mobile' => ['required', 'string', 'min:10'],
        'email' => ['required', 'string', 'email:rfc,dns', 'min:2', 'max:255'],
        'pin' => ['required', 'string', 'min:4', 'max:16'],
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
        'id_no' => ['string', 'nullable'],
        'id_issue_country' => ['string', 'nullable'],
        'id_expired_at' => ['string', 'nullable'],
        'id_issue_at' => ['string', 'nullable'],
        'photo' => ['string', 'nullable'],
        'documents' => ['array', 'required', 'min:1'],
        'documents.*.type' => ['string', 'required'],
        'documents.*.back' => ['string', 'required_without:documents.*.front'],
        'documents.*.front' => ['string', 'required_without:documents.*.back'],
        'proof_of_address' => ['array', 'required', 'min:1'],
        'proof_of_address.*.type' => ['string', 'required'],
        'proof_of_address.*.back' => ['string', 'required_without:proof_of_address.*.front'],
        'proof_of_address.*.front' => ['string', 'required_without:proof_of_address.*.back'],
        'date_of_birth' => ['date', 'nullable'],
        'permanent_address' => ['string', 'nullable'],
        'city_id' => ['integer', 'nullable'],
        'state_id' => ['integer', 'nullable'],
        'country_id' => ['integer', 'nullable'],
        'post_code' => ['string', 'nullable'],
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
    //'middleware' => ['auth:sanctum'],
    'middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'repositories' => [
        \Fintech\Auth\Interfaces\PermissionRepository::class => \Fintech\Auth\Repositories\Eloquent\PermissionRepository::class,

        \Fintech\Auth\Interfaces\RoleRepository::class => \Fintech\Auth\Repositories\Eloquent\RoleRepository::class,

        \Fintech\Auth\Interfaces\TeamRepository::class => \Fintech\Auth\Repositories\Eloquent\TeamRepository::class,

        \Fintech\Auth\Interfaces\ProfileRepository::class => \Fintech\Auth\Repositories\Eloquent\ProfileRepository::class,

        \Fintech\Auth\Interfaces\UserRepository::class => \Fintech\Auth\Repositories\Eloquent\UserRepository::class,

        \Fintech\Auth\Interfaces\OneTimePinRepository::class => \Fintech\Auth\Repositories\Eloquent\OneTimePinRepository::class,

        \Fintech\Auth\Interfaces\AuditRepository::class => \Fintech\Auth\Repositories\Eloquent\AuditRepository::class,

        \Fintech\Auth\Interfaces\IdDocTypeRepository::class => \Fintech\Auth\Repositories\Eloquent\IdDocTypeRepository::class,

        //** Repository Binding Config Point Do not Remove **//
    ],

];
