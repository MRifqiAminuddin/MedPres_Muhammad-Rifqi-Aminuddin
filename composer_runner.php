<?php

// PENGAMAN ENV
if (!in_array($_SERVER['REMOTE_ADDR'], ['YOUR.IP.ADDRESS'])) {
    http_response_code(403);
    exit('Forbidden');
}

// CEK EXEC AKTIF
if (!function_exists('shell_exec')) {
    exit('shell_exec disabled');
}

// PATH COMPOSER (SESUIKAN)
$composer = '/usr/bin/composer';
// atau: $composer = 'composer';
// atau: $composer = 'php composer.phar';

// COMMAND HARDCODE
$command = escapeshellcmd("$composer install --no-dev --optimize-autoloader");

// EKSEKUSI
$output = shell_exec($command . ' 2>&1');

echo '<pre>' . htmlspecialchars($output) . '</pre>';
