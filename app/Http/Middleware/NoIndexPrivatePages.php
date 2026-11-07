<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoIndexPrivatePages
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $response = $next($request);

        if ($this->shouldNoIndex($request)) {
            $response->headers->set(
                'X-Robots-Tag',
                'noindex, nofollow, noarchive'
            );
        }

        return $response;
    }


    private function shouldNoIndex(
        Request $request
    ): bool {
        return $request->is(
            'admin',
            'admin/*',

            'user',
            'user/*',

            'login',
            'register',

            'forgot-password',
            'reset-password/*',

            'email/verify',
            'email/verify/*',

            'upload-file'
        );
    }
}
