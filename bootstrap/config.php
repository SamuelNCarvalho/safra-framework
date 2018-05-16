<?php

use function DI\create;

return  [
	// Configure Twig
    Twig_Environment::class => function () {
		$loader = new Twig_Loader_Filesystem(realpath(__DIR__ . '/../app/views'));
        return new Twig_Environment($loader);
    },
];
