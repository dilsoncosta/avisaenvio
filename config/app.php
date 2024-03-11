<?php

use Illuminate\Support\Facades\Facade;

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),
    
    /* Defines Env */
    'mail_from_address' => env('MAIL_FROM_ADDRESS', 'system@controlei.com.br'),
    'mail_from_name'    => env('MAIL_FROM_NAME', 'Controlei'),

    'url' => env('APP_URL', ''),

    'path_relat' => env('APP_PATH_RELAT', ''),

    'api_whatsapp_ambiente'  => env('API_WHATSAPP_AMBIENTE', 'hmg'),
    'api_whatsapp_filename1' => env('API_WHATSAPP_FILENAME_1', ''),
    'api_whatsapp_file1'     => env('API_WHATSAPP_FILE_1', ''),
    'api_whatsapp_filename2' => env('API_WHATSAPP_FILENAME_2', ''),
    'api_whatsapp_file2'     => env('API_WHATSAPP_FILE_2', ''),
    'api_whatsapp_filename3' => env('API_WHATSAPP_FILENAME_3', ''),
    'api_whatsapp_file3'      => env('API_WHATSAPP_FILE_3', ''),

    'api_whatsapp_webhook_prd'      => env('API_WHATSAPP_WEBHOOK_PRD', ''),

    'api_whatsapp_webhook_hmg'      => env('API_WHATSAPP_WEBHOOK_HMG', ''),

    'asset_url' => env('ASSET_URL'),

    'api_whatsapp_path_main' => env('API_WHATSAPP_URL_MAIN', ''),

    'api_whatsapp_secret_key' => env('API_WHATSAPP_SECRET_KEY', ''),

    'api_link_track_secret_key' => env('API_LINK_TRACK_SECRET_KEY', ''),

    'api_link_track_user' => env('API_LINK_TRACK_USER', ''),

    'timezone' => 'America/Sao_Paulo',

    'locale' => 'pt_BR',

    'fallback_locale' => 'pt_BR',

    'faker_locale' => 'pt_BR',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),

];
