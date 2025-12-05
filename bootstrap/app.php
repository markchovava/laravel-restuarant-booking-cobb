<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'api/',
            'api/*',
            'https://*.vercel.app',  
            'http://127.0.0.1:8000',
            'http://127.0.0.1:8000/',
            'http://127.0.0.1:8000/*',
            'https://next-restuarant-booking-cobb.vercel.app',
            'https://next-restuarant-booking-cobb.vercel.app/',
            'https://next-restuarant-booking-cobb.vercel.app/*',
            'https://next-restuarant-booking-cobb.vercel.app/auth/login',
            'https://next-restuarant-booking-cobb.vercel.app/auth/login/',
            'https://next-restuarant-booking-cobb.vercel.app/auth/login/*',
            'https://next-restuarant-booking-cobb.vercel.app/auth/register',
            'https://next-restuarant-booking-cobb.vercel.app/auth/register/',
            'https://next-restuarant-booking-cobb.vercel.app/auth/register/*',
            'login',
            'register',
            'login/*',
            'register/*',
            'message',
            'message/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
