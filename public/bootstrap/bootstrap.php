<?php

use Symfony\Component\HttpFoundation\{Request, Response};

require_once __DIR__ . '/../../vendor/autoload.php';
//вывод всех ошибок
$app = new Silex\Application(
    [
        'debug' => false,
    ]
);


//$app->register(new Silex\Provider\RoutingServiceProvider());

//twig
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../../templates'
]);
//
$app->register(new Silex\Provider\SessionServiceProvider(), [
    'session.test' => false
]);

$app->register(new Silex\Provider\AssetServiceProvider(), [
    'assets.version' => 'v1',
    'assets.version_format' => '%s?version=%s',
    'assets.named_packages' => [
        'css' => [
            'base_path' => __DIR__ . '../../public'
        ],
         'requirejs_output_dir' => __DIR__.'/../public',
        'images' => ['bath_path' => ['../../public']]
    ]
]);

require_once __DIR__ . '/../../routes/routes.php';