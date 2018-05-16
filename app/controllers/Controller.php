<?php

namespace Controllers;

use Twig_Environment;

class Controller
{
	/**
     * @var Twig_Environment
     */
    protected $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

}
