<?php
/**
 * Environment variable loader
 * Reads .env file from project root and sets environment variables
 */
function load_env($path = null) {
    $path = $path ?? dirname(__DIR__) . '/.env';
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        if (strpos($line, '=') === false) continue;

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // Remove surrounding quotes
        if (preg_match('/^"(.*)"$/', $value, $m)) $value = $m[1];
        if (preg_match("/^'(.*)'$/", $value, $m)) $value = $m[1];

        if (!getenv($key)) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

load_env();

// Production error handling — never leak errors to users
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
