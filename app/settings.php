<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

use function DI\env;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => env('APP_NAME'),
                'path' => __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ]
        ],
    ]);
};
