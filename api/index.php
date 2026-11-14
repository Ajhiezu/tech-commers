<?php

// Vercel's application bundle is read-only; Laravel writes temporary files here.
$storage = '/tmp/techcommers-storage';

foreach (['app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $directory) {
    $path = $storage . '/' . $directory;

    if (!is_dir($path) && !mkdir($path, 0775, true) && !is_dir($path)) {
        throw new RuntimeException('Unable to create Laravel temporary directory.');
    }
}

$defaults = [
    'VIEW_COMPILED_PATH' => $storage . '/framework/views',
    'APP_CONFIG_CACHE' => $storage . '/config.php',
    'APP_EVENTS_CACHE' => $storage . '/events.php',
    'APP_PACKAGES_CACHE' => $storage . '/packages.php',
    'APP_ROUTES_CACHE' => $storage . '/routes.php',
    'APP_SERVICES_CACHE' => $storage . '/services.php',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => 'cookie',
    'SESSION_SECURE_COOKIE' => 'true',
    'CACHE_STORE' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'MAIL_MAILER' => 'log',
];

foreach ($defaults as $name => $value) {
    if (getenv($name) === false && !isset($_ENV[$name]) && !isset($_SERVER[$name])) {
        putenv($name . '=' . $value);
        $_ENV[$name] = $_SERVER[$name] = $value;
    }
}

$_ENV['LARAVEL_STORAGE_PATH'] = $_SERVER['LARAVEL_STORAGE_PATH'] = $storage;

// Vercel terminates HTTPS before forwarding requests to the PHP runtime.
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = '443';

require __DIR__ . '/../public/index.php';
