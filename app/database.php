<?php

return function () {
    $envFile = __DIR__ . '/../.env';
    if (!file_exists($envFile)) {
        throw new RuntimeException('Could not find .env file');
    }
    $env = parse_ini_file($envFile);
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $env['DB_HOST'], $env['DB_NAME'], $env['DB_CHARSET']);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASSWORD'], $options);
    //print_r($pdo);die;
    return new PDO($dsn, $env['DB_USER'], $env['DB_PASSWORD'], $options);
};
