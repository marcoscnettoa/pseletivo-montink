<?php
// # MXTera -
namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if(! $request->expectsJson()) {
            return config('app.url').'/app/acesso';
        }

        return null;
    }
}
