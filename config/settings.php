<?php

declare(strict_types=1);

use Monolog\Logger;

use function DI\env;
use function DI\get;

return [
    // display errors
    'displayErrorDetails' => true,
    // logger
    'logger.name' => env('APP_NAME'),
    'logger.path' => __DIR__ . '/../logs/app.log',
    'logger.level' => Logger::DEBUG,
    // migrations
    'doctrine.migrations.name' => 'migration',
    'doctrine.migrations.namespace' => 'App\\Migrations',
    'doctrine.migrations.table_name' => 'doctrine_migration_versions',
    'doctrine.migrations.column_name' => 'version',
    'doctrine.migrations.migration_directory' => 'src/Migrations',
    // orm
    'doctrine.meta.entity_path' => [
        __DIR__ . '/../src/Entity'
    ],
    'doctrine.meta.auto_generate_proxies' => env('DEV_MODE'),
    'doctrine.meta.proxy_dir' =>  __DIR__ . '/../var/cache/DoctrineORM/proxies',
    'doctrine.meta.cache' => null,
    // 'doctrine.meta.cache' => get(\Doctrine\Common\Cache\ApcuCache::class),
    // Connection
    'doctrine.connection' => [
        'driver' => 'pdo_mysql',
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT'),
        'dbname' => env('DB_NAME'),
        'user' => env('DB_USER'),
        'password' => env('DB_PASS'),
        'charset' => 'utf8mb4',
        'platform' => get(\Doctrine\DBAL\Platforms\MySQL57Platform::class),
    ],
];
