<?php

$allowedOrigin = isset($_ENV['FRONTEND_URL']) && trim($_ENV['FRONTEND_URL']) != "" 
    ? $_ENV['FRONTEND_URL'] 
    : 'http://localhost/Flower_Shop/frontend';

// Set CORS headers for ALL requests
header("Access-Control-Allow-Origin: " . $allowedOrigin);
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: content-type, Content-Type, Authorization, Authentication, Accept, Origin");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Handle OPTIONS preflight - respond and exit immediately
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Content-Length: 0");
    header("Content-Type: text/plain");
    http_response_code(204);
    exit(0);
}

require 'vendor/autoload.php'; 

require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/OrderService.php';
require_once __DIR__ . '/services/OrderDetailsService.php';
require_once __DIR__ . '/services/ProductService.php';
require_once __DIR__ . '/services/ReviewService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/AuthService.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/data/roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::before('start', function() {
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0 ||
        /*strpos(Flight::request()->url, '/public') === 0 */
        str_starts_with(Flight::request()->url, '/public')
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});


Flight::register('categoryService', 'CategoryService');
Flight::register('orderService', 'OrderService');
Flight::register('orderDetailsService', 'OrderDetailsService');
Flight::register('productService', 'ProductService');
Flight::register('reviewService', 'ReviewService');
Flight::register('userService', 'UserService');
Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', "AuthMiddleware");

require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderDetailsRoutes.php';
require_once __DIR__ . '/routes/ProductRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/AuthRoutes.php';

Flight::start();  
?>
