<?php

declare(strict_types=1);

require 'vendor/autoload.php';
$settings = require 'config/settings.php';

use App\DbFixtures\MunicipioLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

$loader = new Loader();
$loader->addFixture(new MunicipioLoader());

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['doctrine.meta.entity_path'],
    (bool) $settings['doctrine.meta.auto_generate_proxies'],
    $settings['doctrine.meta.proxy_dir']
);

$em = EntityManager::create($settings['doctrine.connection'], $config);

$purger = new ORMPurger();
$executor = new ORMExecutor($em, $purger);
$executor->execute($loader->getFixtures());
