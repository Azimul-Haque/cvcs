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
        '/api/users/member/authenticate',
        '/api/users/member/update',
        '/api/users/member/selfpayments',
        '/api/users/member/selfpayments/receipt',
    ];
}
