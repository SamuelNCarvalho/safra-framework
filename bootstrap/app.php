<?php

// Setup Dotenv
try {
    (new Dotenv\Dotenv(realpath(__DIR__.'/../')))->load();
} catch (Dotenv\Exception\InvalidPathException $e) 
{
}

// Setup application
$app = Core\Application::getInstance();
$app->setBasePath(realpath(__DIR__.'/../'));
$app->setContainerDefinitionsFilePath($app->getBasePath().'/app/config/definitions.php');

// Routes
$app->router->add('get', '/', ['Controllers\HomeController', 'index']);

return $app;