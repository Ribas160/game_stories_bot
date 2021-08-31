<?php 
set_time_limit(600);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;

$app = new App();
$app->run();