<?php

// Require vendor autoload
require realpath(__DIR__.'/../vendor/autoload.php');

// require application instance
$app = require realpath(__DIR__.'/../bootstrap/app.php');

// Run application
$app->run();