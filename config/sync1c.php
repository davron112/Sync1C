<?php

return [
	'base_url'             => env('1C-SYNC_BASE_URL', ''),
	'prefix'               => env('1C-SYNC_DEFAULT_PREFIX', ''),
	'show_errors_flag'     => env('1C-SYNC_SHOW_HTTP_ERRORS', false),
	'log_path'             => env('1C-SYNC_LOG_PATH', false),
	'token_cache_name'     => env('1C-SYNC_TOKEN_CACHE_NAME', ''),
	'token_cache_lifetime' => env('1C-SYNC_TOKEN_CACHE_LIFETIME', 60),
	'auth'                 => [
        'user'     => env('1C-SYNC_USER', ''),
        'password' => env('1C-SYNC_PASSWORD', ''),
    ],
];
