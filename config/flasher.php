<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Notification Library
    |--------------------------------------------------------------------------
    |
    | This option controls the default notification library that will be used
    | by the flasher library to display notifications.
    |
    */

    'default' => 'toastr',

    /*
    |--------------------------------------------------------------------------
    | Global Options
    |--------------------------------------------------------------------------
    |
    | These options can be used to set global options for all notification
    | libraries that are supported by flasher.
    |
    */

    'root_script' => '/vendor/flasher/',

    'translate' => true,

    'inject_assets' => true,

    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Libraries
    |--------------------------------------------------------------------------
    |
    | Here you can specify which notification libraries you wish to use.
    |
    */

    'plugins' => [
        'toastr' => [
            'scripts' => [
                '/vendor/flasher/flasher.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
            'styles' => [
                '/vendor/flasher/toastr.min.css',
            ],
            'options' => [
                "closeButton" => true,
                "debug" => false,
                "newestOnTop" => true,
                "progressBar" => true,
                "positionClass" => "toast-top-right",
                "preventDuplicates" => false,
                "onclick" => null,
                "showDuration" => "300",
                "hideDuration" => "1000",
                "timeOut" => "5000",
                "extendedTimeOut" => "1000",
                "showEasing" => "swing",
                "hideEasing" => "linear",
                "showMethod" => "fadeIn",
                "hideMethod" => "fadeOut"
            ],
        ],
    ],
];
