<?php

use RSJWT\App;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$rsjwt = new App($app);

$rsjwt->run();