<?php
declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
}

if (method_exists(Dotenv::class, 'overload')) {
    (new Dotenv(true))->overload(dirname(__DIR__) . '/.env.phpunit');
    $_SERVER += $_ENV;
}
