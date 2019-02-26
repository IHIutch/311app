<?php

date_default_timezone_set('America/New_York');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/lib/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

require __DIR__ . '/lib/db.php';
require __DIR__ . '/lib/s3.php';
require __DIR__ . '/lib/mailgun.php';
//require __DIR__ . '/lib/report_list.php';
//require __DIR__ . '/lib/create.php';

session_cache_limiter(false);
session_start();

$config = [
        'displayErrorDetails' => getenv('DISPLAY_ERRORS'),
 
        'logger' => [
            'name' => 'slim-app',
            'level' => getenv('LOG_LEVEL') ?: 400,
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ];

//$config['displayErrorDetails'] = true;
//$config['addContentLengthHeader'] = false;


$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./templates/');
};


//$app->configureMode('production', function () use ($app) {
//    $app->config(array(
//        'log.enable' => true,
//        'debug' => false,
//    ));
//});
//
//$app->configureMode('development', function () use ($app) {
//    $app->config(array(
//        'log.enable' => false,
//        'debug' => true,
//    ));
//});

require __DIR__ . '/lib/routes/report.php';
require __DIR__ . '/lib/routes/profile.php';
require __DIR__ . '/lib/routes/report_list.php';
require __DIR__ . '/lib/routes/create.php';


$app->run();

