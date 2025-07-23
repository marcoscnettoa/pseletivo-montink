<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: 'check-health-get-http-up', #'/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
        ]);

        // append: [],prepend: [],remove: [],replace: []
        $middleware->web(
            /* ... */
        );

        // append: [],prepend: [],remove: [],replace: []
        $middleware->api(
            //prepend: [
            //    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class
            //]
        );

        $middleware->appendToGroup('web', [
            /* ... */
        ]);

        $middleware->appendToGroup('api', [
            /* ... */
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if(
                ( $e->getStatusCode() === 419 ) &&
                ( $e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException )
            ) {
                return (new \App\Exceptions\TokenMismatchException)->handle($e, $request);
            }
        });
    })->create();
