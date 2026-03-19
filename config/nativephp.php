<?php

return [

    /*
    |--------------------------------------------------------------------------
    | NativePHP Mobile Configuration
    |--------------------------------------------------------------------------
    | App ID must match your Android package name exactly.
    | It must be in reverse-domain format: com.company.appname
    */

    'app_id'      => env('NATIVEPHP_APP_ID', 'com.bhramanikhandavi.farsanhub'),
    'app_name'    => env('APP_NAME', 'Bhramani Khandavi House'),
    'app_version' => env('NATIVEPHP_APP_VERSION', '1.0.0'),
    'api_version' => 1,

    /*
    |--------------------------------------------------------------------------
    | Deep Link Scheme
    |--------------------------------------------------------------------------
    | Used for OAuth callbacks and deep links from external apps.
    | e.g. farsanhub://auth/google/callback
    */
    'deeplink_scheme' => env('NATIVEPHP_DEEPLINK_SCHEME', 'farsanhub'),

    /*
    |--------------------------------------------------------------------------
    | App Entry Point
    |--------------------------------------------------------------------------
    | The first URL opened when the app launches.
    */
    'entry_point' => '/admin',

    /*
    |--------------------------------------------------------------------------
    | Android Configuration
    |--------------------------------------------------------------------------
    */
    'android' => [
        'min_sdk_version'    => 26,   // Android 8.0 minimum
        'target_sdk_version' => 34,   // Android 14

        'signing' => [
            'store_path'     => env('ANDROID_KEYSTORE_PATH', ''),
            'store_password' => env('ANDROID_KEYSTORE_PASSWORD', ''),
            'key_alias'      => env('ANDROID_KEY_ALIAS', 'farsanhub'),
            'key_password'   => env('ANDROID_KEY_PASSWORD', ''),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Android Permissions
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'android.permission.INTERNET',
        'android.permission.READ_EXTERNAL_STORAGE',
        'android.permission.WRITE_EXTERNAL_STORAGE',
        'android.permission.CAMERA',
        'android.permission.VIBRATE',
        'android.permission.RECEIVE_BOOT_COMPLETED',
    ],

    /*
    |--------------------------------------------------------------------------
    | Bundled PHP Server Port
    |--------------------------------------------------------------------------
    */
    'php_port' => env('NATIVEPHP_PHP_PORT', 8080),

    /*
    |--------------------------------------------------------------------------
    | Secret Key (for internal API communication between WebView and native)
    |--------------------------------------------------------------------------
    */
    'secret' => env('NATIVEPHP_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Firebase / Push Notifications
    |--------------------------------------------------------------------------
    | Place your google-services.json file in the project root directory.
    | NativePHP will copy it into the Android project during build.
    */
    'fcm' => [
        'server_key' => env('FCM_SERVER_KEY', ''),
        'project_id' => env('FIREBASE_PROJECT_ID', ''),
    ],

];
