<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
            'prevent.banned' => \App\Http\Middleware\PreventBannedUser::class,
            'track.viewed' => \App\Http\Middleware\TrackRecentlyViewed::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\PreventBannedUser::class,
            \App\Http\Middleware\TrackRecentlyViewed::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
