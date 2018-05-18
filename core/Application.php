<?php

namespace Core;

use DI\ContainerBuilder;

class Application
{
     /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

    /**
     * Application base path
     *
     * @var string
     */
    private $basePath;

    /**
     * Application container path
     *
     * @var string
     */
    private $containerDefinitionsFilePath;

    /**
     * DI Container
     *
     * @var ContainerBuilder
     */
    private $container;

    /**
     * Router class
     *
     * @var Router
     */
    public $router;

    /**
     * Request class
     *
     * @var Request
     */
    public $request;

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
     * Constructor method
     */
    private function __construct()
    {
        $this->bootstrapRouter();
        $this->bootstrapRequest();
    }

    /**
     * Set application base path
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
     * Set container definitions path
     *
     * @param string $containerDefinitionsFilePath
     * @return void
     */
    public function setContainerDefinitionsFilePath($containerDefinitionsFilePath)
    {
        $this->containerDefinitionsFilePath = $containerDefinitionsFilePath;
    }

    /**
     * Return container definitions path
     *
     * @return string
     */
    private function getContainerDefinitionsFilePath()
    {
        return $this->containerDefinitionsFilePath;
    }

    /**
     * Return application name
     *
     * @return string
     */
    public function name()
    {
        return config('app.name');
    }

    /**
     * Lazy load DI Container
     *
     * @return ContainerBuilder
     */
    public function container()
    {
        if (is_null($this->container)) {
            $containerBuilder = new ContainerBuilder;

            if (empty($this->containerDefinitionsFilePath)){
                $definitions = [];
            } else {
                $definitions = $this->containerDefinitionsFilePath;
            }

            $containerBuilder->addDefinitions($definitions);
            $this->container = $containerBuilder->build();
        }

        return $this->container;
    }

    /**
     * Return DI Container definition
     *
     * @param any $param
     * @return any
     */
    public function get($param)
    {
        return $this->container()->get($param);
    }

    /**
     * Set DI Container definition
     *
     * @param any $param
     * @return void
     */
    public function set($key, $value)
    {
        $this->container()->set($key, $value);
    }

    /**
     * Bootstrap router class
     *
     * @return void
     */
    private function bootstrapRouter()
    {
        $this->router = new Router;
    }

    /**
     * Bootstrap request class
     *
     * @return void
     */
    private function bootstrapRequest()
    {
        $this->request = new Request;
    }

    /**
     * Run application
     *
     * @return void
     */
    public function run()
    {
        $response = $this->router->run(
            $this->request->method(),
            $this->request->uri()
        );

        if (!empty($response)) {
            return $this->container()->call($response[0], $response[1]);
        }

        echo "404 Not Found";

        exit();
    }


    private function __clone()
    {
    }
}