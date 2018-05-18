<?php
return [
    'app.config_path' => base_path().'/app/config',
    'app.public_path' => base_path().'/public',
    Twig_Environment::class => function () {
        $loader = new Twig_Loader_Filesystem(base_path().'/app/views');
        return new Twig_Environment($loader, [
            // 'cache' => base_path().'/cache/views'
        ]);
    },
];