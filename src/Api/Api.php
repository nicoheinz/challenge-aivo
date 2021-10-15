<?php

require 'vendor/autoload.php';

$app = new Slim\App();

require 'Routers.php';

$app->run();
