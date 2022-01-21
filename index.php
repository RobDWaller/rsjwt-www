<?php

use DI\Container;
use RSJWT\App;
use Slim\Factory\AppFactory;
use RSJWT\JWT\JWTFactory;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Secret;
use ReallySimpleJWT\Helper\Validator;
use ReallySimpleJWT\Encoders\EncodeHS256;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->set('jwtFactory', function () {
    $build = new Build('JWT', new Validator(), new Secret(), new EncodeHS256());
    return new JWTFactory($build);
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$rsjwt = new App($app);

$rsjwt->run();