<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'payment/*',
        'application/payment/success',
        'application/payment/cancel/*',
        'dashboard/easyperiod/store/message/api',
        'dashboard/easyperiod/store/userimage/api',
        'dashboard/easyperiod/store/post/api',
        'dashboard/easyperiod/store/post/reply/api',
    ];
}
