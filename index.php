<?php

use DI\Container;
use RSJWT\App;
use Slim\Factory\AppFactory;
use RSJWT\JWT\Factory;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256Strong;
use Automata\Automata;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->set('jwtFactory', function () {
    $build = new Build('JWT', new Validator(), new EncodeHS256Strong('!secReT$123*'));
    return new Factory($build);
});

$container->set('automata', function ($initialState, $rule) {
    return new Automata();
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$rsjwt = new App($app);

$rsjwt->run();