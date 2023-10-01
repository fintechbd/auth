<?php

// config for Fintech/Auth
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
    | Login Validation
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'validation' => [
        'login' => [
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string', \Illuminate\Validation\Rules\Password::default()],
        ],
        'register' => [
            //user
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'mobile' => ['required', 'string', 'min:10'],
            'email' => ['required', 'string', 'email:rfc,dns', 'min:2', 'max:255'],
            'login_id' => ['required', 'string', 'min:6', 'max:255'],
            'password' => ['required', 'string', \Illuminate\Validation\Rules\Password::default()],
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
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Lock Up Threshold
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'threshold' => [
        'password' => 10,
        'pin' => 3,
    ],

    'threshold_notification' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Middleware
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'middleware' => ['auth:sanctum'],
];
