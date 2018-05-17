<?php

namespace Core;

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

class Application {

	/**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

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
	 * DI Container definitions
	 *
	 * @var array
	 */
	private $containerDefinitions = [];

	/**
	 * Router
	 *
	 * @var Router
	 */
	private $router;

	private function __construct()
	{
		$this->bootstrapExceptionHandler();
		$this->bootstrapORM();
	}


	/**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

	/**
	 * Bootstrap DI container
	 *
	 * @return void
	 */
	public function container()
	{
		if (is_null($this->container)) {
			$container = new ContainerBuilder;
			$this->setupBaseContainerDefinitions();
			$container->addDefinitions($this->containerDefinitions);
			$this->container = $container->build();
		}

		return $this->container;
	}

	/**
	 * Set base path
	 *
	 * @param string $basePath
	 * @return void
	 */
	public function setBasePath($basePath)
	{
		$this->basePath = $basePath;
	}

	/**
	 * Return application base path
	 *
	 * @return string
	 */
	public function getBasePath()
	{
		return $this->basePath;
	}

	/**
	 * Bootstrap router
	 *
	 * @return void
	 */
	private function router()
	{
		if (is_null($this->router)) {
			$dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $route) {
				require $this->getBasePath().'/app/routes.php';
			});

			$this->router = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
		}

		return $this->router;
	}

	/**
	 * Bootstrap ORM
	 *
	 * @return void
	 */
	private function bootstrapORM()
	{
		$con = new \PDO(getenv('DB_DRIVER'). ':host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
		\TORM\Connection::setConnection($con);
		\TORM\Connection::setDriver(getenv('DB_DRIVER'));
	}

	/**
	 * Bootstrap Whoops exception handler
	 *
	 * @return void
	 */
	private function bootstrapExceptionHandler()
	{
		$whoops = new \Whoops\Run;
		$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$whoops->register();
	}

	/**
	 * Setup container definitions
	 *
	 * @return void
	 */
	private function setupBaseContainerDefinitions()
	{
		$this->containerDefinitions += [];
	}

	/**
	 * Add container definitions
	 *
	 * @param array $definition
	 * @return void
	 */
	public function addContainerDefinitions($definitions)
	{
		if (!is_array($definitions) && is_string($definitions)) {
			$definitions = require $definitions;
		}

		$this->containerDefinitions += $definitions;
	}

	/**
	 * Return response
	 *
	 * @return void
	 */
	public function response()
	{
		switch ($this->router()[0]) {
			case Dispatcher::NOT_FOUND:
				echo '404 Not Found';
				break;

			case Dispatcher::METHOD_NOT_ALLOWED:
				echo '405 Method Not Allowed';
				break;

			case Dispatcher::FOUND:
				$handler = $this->router()[1];
				$vars = $this->router()[2];

				$this->container()->call($handler, $vars);
				break;
		}
	}

}