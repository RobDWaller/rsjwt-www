<?php

use DI\Container;
use RSJWT\App;
use Slim\Factory\AppFactory;
use RSJWT\JWT\JWTFactory;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256Strong;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->set('jwtFactory', function () {
    $build = new Build('JWT', new Validator(), new EncodeHS256Strong('!secReT$123*'));
    return new JWTFactory($build);
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$rsjwt = new App($app);

$rsjwt->run();