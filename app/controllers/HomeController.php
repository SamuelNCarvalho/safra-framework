<?php

namespace Controllers;

class HomeController extends Controller
{
	public function index()
    {
		echo $this->twig->render('home.twig');
    }
}
