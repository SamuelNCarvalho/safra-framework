<?php

namespace Bootstrap\Setup;

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

class Application {

	/**
	 * Base path of application
	 *
	 * @var string
	 */
	private $basePath;

	/**
	 * DI Container
	 *
	 * @var DI\ContainerBuilder
	 */
	private $container;

	/**
	 * Router
	 *
	 * @var [type]
	 */
	private $route;

	public function __construct($basePath)
	{
		$this->basePath = $basePath;

		$this->bootstrapContainer();
		$this->bootstrapRouter();
	}

	/**
	 * Bootstrap DI container
	 *
	 * @return void
	 */
	private function bootstrapContainer()
	{
		$container = new ContainerBuilder;
		$container->addDefinitions(realpath(__DIR__ . '/../config.php'));
		$this->container = $container->build();
	}

	/**
	 * Bootstrap router
	 *
	 * @return void
	 */
	private function bootstrapRouter()
	{
		$dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $route) {
			require realpath(__DIR__.'/../../app/routes.php');
		});

		$this->route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
	}

	/**
	 * Return response
	 *
	 * @return void
	 */
	public function response()
	{
		switch ($this->route[0]) {
			case Dispatcher::NOT_FOUND:
				echo '404 Not Found';
				break;

			case Dispatcher::METHOD_NOT_ALLOWED:
				echo '405 Method Not Allowed';
				break;

			case Dispatcher::FOUND:
				$handler = $this->route[1];
				$vars = $this->route[2];

				$this->container->call($handler, $vars);
				break;
		}
	}

}