<?php

require __DIR__ . '/vendor/autoload.php';

use Controller\FrontController;

$databaseConfig = require __DIR__ . '/config/database.php';

$frontController = new FrontController($databaseConfig);
echo $frontController->handle();
