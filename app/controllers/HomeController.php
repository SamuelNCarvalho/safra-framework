<?php

namespace Controllers;

class HomeController
{
    public function index()
    {
        $welcomeMessage = 'Welcome to '.app()->name();
        view('home.twig', compact('welcomeMessage'));
    }
}