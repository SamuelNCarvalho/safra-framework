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
 * @return string
 */
function base_path()
{
	return app()->getBasePath();
}