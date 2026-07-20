<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// استيراد الـ Middleware الصحيح الخاص بك
use App\Http\Middleware\FirebaseAuth; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        $middleware->alias([
            'firebase.auth' => FirebaseAuth::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();