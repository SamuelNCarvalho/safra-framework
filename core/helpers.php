<?php

/**
 * Return application instance
 *
 * @return Core\Application
 */
function app()
{
    return Core\Application::getInstance();
}

/**
 * Return application base path
 *
 * @return void
 */
function base_path()
{
    return app()->getBasePath();
}

/**
 * Return a configuration data
 *
 * @param string $param
 * @return any
 */
function config($param)
{
    $params = explode('.', $param);

    $configPath = app()->get('app.config_path');

    if (!empty($configPath) && file_exists($configPath.'/'.reset($params).'.php')) {
        $configFile = require $configPath.'/'.reset($params).'.php';

        if (isset($configFile[$params[1]])) {
            return $configFile[$params[1]];
        } 
    }

    return null;
}

/**
 * Render file with Twig
 *
 * @param string $file
 * @param array $parameters
 * @return void
 */
function view($file, $parameters = [])
{
    $twig  = app()->get(Twig_Environment::class);

    echo $twig->render($file, $parameters);
    return;
}