<?php
ini_set('display_errors', 0);
error_reporting(0);


require __DIR__ . '/../../../vendor/autoload.php';

if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
    define('BASE_URL', 'http://localhost/Flower_Shop/backend');
} else {
    define('BASE_URL', 'https://flowershop-backend-app-rnlqx.ondigitalocean.app');
}

$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../routes'
]);
header('Content-Type: application/json');
echo $openapi->toJson();
?>