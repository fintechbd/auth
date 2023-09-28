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
