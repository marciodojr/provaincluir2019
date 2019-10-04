<?php

use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManager;

require 'vendor/autoload.php';

$settings = require 'settings.php';

$metadataConfiguration = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['doctrine.meta.entity_path'],
    $settings['doctrine.meta.auto_generate_proxies'],
    $settings['doctrine.meta.proxy_dir'],
    $settings['doctrine.meta.cache'],
    false
);

$em = EntityManager::create($settings['doctrine.connection'], $config);

// Migrations Configuration
$connection = $em->getConnection();
$configuration = new Configuration($connection);

$configuration->setName($settings['doctrine.migrations.name']);
$configuration->setMigrationsNamespace($settings['doctrine.migrations.namespace']);
$configuration->setMigrationsTableName($settings['doctrine.migrations.table_name']);
$configuration->setMigrationsColumnName($settings['doctrine.migrations.column_name']);
$configuration->setMigrationsDirectory($settings['doctrine.migrations.migration_directory']);

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($connection),
    new ConfigurationHelper($connection, $configuration)
]);
