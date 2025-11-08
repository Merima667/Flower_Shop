<?php
require 'vendor/autoload.php'; 

require_once __DIR__ . '/services/AdminService.php';
Flight::register('adminService', 'AdminService');

require_once __DIR__ . '/services/CategoryService.php';
Flight::register('categoryService', 'CategoryService');

require_once __DIR__ . '/services/CustomerService.php';
Flight::register('customerService', 'CustomerService');

require_once __DIR__ . '/services/OrderService.php';
Flight::register('orderService', 'OrderService');

require_once __DIR__ . '/services/OrderDetailsService.php';
Flight::register('orderDetailsService', 'OrderDetailsService');

require_once __DIR__ . '/services/ProductService.php';
Flight::register('productService', 'ProductService');

require_once __DIR__ . '/services/ReviewService.php';
Flight::register('reviewService', 'ReviewService');


require_once __DIR__ . '/routes/AdminRoutes.php';
require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/CustomerRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderDetailsRoutes.php';
require_once __DIR__ . '/routes/ProductRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';

Flight::start();  
?>
