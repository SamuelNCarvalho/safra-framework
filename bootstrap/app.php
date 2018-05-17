<?php
// require autoload of vendors
require realpath(__DIR__.'/../vendor/autoload.php');

// setup .env
try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {}

// setup application
$app = Core\Application::getInstance();
$app->setBasePath(realpath(__DIR__.'/../'));
$app->addContainerDefinitions($app->getBasePath().'/bootstrap/config.php');

return $app;