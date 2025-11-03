<?php
require_once 'dao/AdminDao.php';
require_once 'dao/CategoryDao.php';
require_once 'dao/CustomerDao.php';
require_once 'dao/OrderDao.php';
require_once 'dao/OrderDetailsDao.php';
require_once 'dao/ProductDao.php';
require_once 'dao/ReviewDao.php';

$adminDao = new AdminDao();
$categoryDao = new CategoryDao();
$customerDao = new CustomerDao();
$orderDao = new OrderDao();
$orderDetailsDao = new OrderDetailsDao();
$productDao = new ProductDao();
$reviewDao = new ReviewDao();

/*$adminInsert = $adminDao->insertAdmin([
   'name' => 'Amina',
   'surname' => 'Kovac',
   'email' => 'amina.kovac@gmail.com',
   'password' => password_hash('Amina2024', PASSWORD_DEFAULT)
]);

echo "Admin insert: " . ($adminInsert ? "Success":"Failed") . "\n";

$categoryInsert = $categoryDao->insertCategory([
   'category_name' => 'roses',
   'description' => 'Classic and romantic roses in various colors. Perfect for expressing love, gratitude, or sympathy on any special occasion.'
]);

echo "Category insert: " . ($categoryInsert ? "Success":"Failed") . "\n";

$customerInsert = $customerDao->insertCustomer([
   'name' => 'Lejla',
   'surname' => 'Bajramovic',
   'email' => 'lejla.bajramovic@gmail.com',
   'password' => password_hash('Lejla456', PASSWORD_DEFAULT),
   'address' => 'Zmaja od Bosne 12'
]);

echo "Customer insert: " . ($customerInsert ? "Success":"Failed") . "\n";

$categoryInsert2 = $categoryDao->insertCategory([
   'category_name' => 'sunflowers',
   'description' => 'Bright and cheerful sunflowers that bring sunshine into any room. Symbol of happiness and positivity.'
]);

echo "Category insert 2: " . ($categoryInsert2 ? "Success":"Failed") . "\n";

$orderInsert = $orderDao->insertOrder([
    'order_date' => date('Y-m-d H:i:s'),
    'status' => 'pending',
    'total' => 75.49,
    'customer_id' => 2
]);

echo "Order insert: " . ($orderInsert ? "Success":"Failed") . "\n";*/

/*$productInsert = $productDao->insertProduct([
   'product_name' => 'Red Roses Bouquet',
   'description' => 'Elegant bouquet of 12 premium red roses with greenery',
   'price' => 45.99,
   'stock' => 15,
   'image_url' => 'red_roses.webp',
   'category_id' => 3,
   'admin_id' => 5
]);

echo "Product insert: " . ($productInsert ? "Success":"Failed") . "\n";
*/
/*$orderDetailsInsert = $orderDetailsDao->insertOrderDetails([
   'description' => 'Red Roses Premium Bouquet - Gift Wrapped',
   'quantity' => 1,
   'product_id' => 7,
   'order_id' => 3,
   'admin_id' => 5
]);

echo "Order details insert: " . ($orderDetailsInsert ? "Success":"Failed") . "\n";
*/
/*$reviewInsert = $reviewDao->insertReview([
   'name' => 'Mirza',
   'review_description' => 'Absolutely stunning roses! My wife loved them. Fast delivery and great quality.',
   'customer_id' => 3,
   'product_id' => 7
]);

echo "Review insert: " . ($reviewInsert ? "Success":"Failed") . "\n";
*//*
$admins = $adminDao->getAll();
print_r($admins);

$categories = $categoryDao->getAll();
print_r($categories);

$customers = $customerDao->getAll();
print_r($customers);

$orders = $orderDao->getAll();
print_r($orders);

$orderDetails = $orderDetailsDao->getAll();
print_r($orderDetails);

$products = $productDao->getAll();
print_r($products);

$reviews = $reviewDao->getAll();
print_r($reviews);

*/
/* TEST FOR GET BY ID */

$admin = $adminDao->getByAdminId(2);
print_r($admin);

$category = $categoryDao->getByCategoryId(2);
print_r($category);

$customer = $customerDao->getByCustomerId(2);
print_r($admin);

$order = $orderDao->getByOrderId(2);
print_r($order);

$product = $productDao->getByProductId(2);
print_r($product);

$orderDetail = $orderDetailsDao->getByOrderDetailsId(2);
print_r($orderDetail);

$review = $reviewDao->getByReviewId(2);
print_r($review);

/* TEST FOR UPDATE */

$adminUpdate = $adminDao->updateAdmin(2, [
   'name' => 'Amina Updated',
   'email' => 'amina.new@gmail.com'
]);
echo "Admin update: " . ($adminUpdate ? "SUCCESS" : "FAILED") . "\n";

$productUpdate = $productDao->update(2, [
   'price' => 42.99,
   'stock' => 10
]);
echo "Product update: " . ($productUpdate ? "SUCCESS" : "FAILED") . "\n";

$orderUpdate = $orderDao->updateOrder(2, [
   'status' => 'shipped'
]);
echo "Order update: " . ($orderUpdate ? "SUCCESS" : "FAILED") . "\n\n";

/* TEST FOR DELETE */

$reviewDelete = $reviewDao->delete(5);
echo "Review delete: " . ($reviewDelete ? "SUCCESS" : "FAILED") . "\n\n";
?>
