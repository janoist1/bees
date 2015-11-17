<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php";

$app = new \Convertize\Bees\Bees();

$app['debug'] = true;

$app->run();
