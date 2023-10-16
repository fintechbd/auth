<?php

// config for fintech/auth
return [

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
    'user_profile_model' => \Fintech\Auth\Models\Profile::class,

    /*
    |--------------------------------------------------------------------------
    | One Time Password/Pin Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'otp_model' => \Fintech\Auth\Models\OneTimePin::class,
    'otp_length' => 4,

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
    | Password Validation
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    | Example: login_id, email, mobile
    */

    'password_field' => 'password',
    'password_field_rules' => ['required', 'string', 'min:8'],
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
            'parent_id' => ['nullable', 'integer'],
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
            'profile_photo' => [\Illuminate\Validation\Rules\File::image(), 'nullable'],
            'scan' => [\Illuminate\Validation\Rules\File::types(['application/pdf', 'image/*']), 'nullable'],
            'scan_1' => [\Illuminate\Validation\Rules\File::types(['application/pdf', 'image/*']), 'nullable'],
            'scan_2' => [\Illuminate\Validation\Rules\File::types(['application/pdf', 'image/*']), 'nullable'],
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
            'note' => ['string', 'nullable'],
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
    //    'middleware' => ['auth:sanctum'],
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

        //** Repository Binding Config Point Do not Remove **//
        ],

];
