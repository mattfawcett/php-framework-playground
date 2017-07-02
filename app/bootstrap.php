<?php
/**
 * The bootstrap file creates and returns the dependency injection container.
 */

use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';
$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config.php');
$container = $containerBuilder->build();
return $container;
