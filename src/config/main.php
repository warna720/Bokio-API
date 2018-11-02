<?php
declare(strict_types=1);

return [
    'email' => env('BOKIO_EMAIL'),
    'password' => env('BOKIO_PASSWORD'),
    'debug' => env('BOKIO_DEBUG', true),
    'disable_sandbox' => env('BOKIO_DISABLE_SANDBOX',true),
    'disable_setuid_sandbox' => env('BOKIO_DISABLE_SETUID_SANDBOX', true),
];