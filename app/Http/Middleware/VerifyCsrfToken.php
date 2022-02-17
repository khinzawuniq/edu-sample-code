<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/mobile/enroll-course',
        '/mobile/update-user-data',
        '/mobile/sync-learning-time',
        '/mobile/reset-password',
        '/mobile/request-verification-code',
        '/mobile/verify-code',
    ];
}
