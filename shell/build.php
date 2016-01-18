<?php
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath, 'home');

$controller = new AppModule\Home();
$controller->build();

/*
$app = new Slim\App(getDefaultSlimConfig());

if (isTraining()) {
    $app->get('/',  'AppModule\Home:build');
}
$app->run();
*/
