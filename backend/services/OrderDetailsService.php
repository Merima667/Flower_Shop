<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderDetailsDao.php';
require_once __DIR__ . '/../dao/OrderDao.php';
require_once __DIR__ . '/../dao/CustomerDao.php';
require_once __DIR__ . '/../dao/ProductDao.php';

class OrderDetailsService extends BaseService {
    protected $customerDao;
    protected $productDao;
    public function __construct() {
        $dao = new OrderDetailsDao();
        $this->customerDao = new CustomerDao();
        $this->productDao = new ProductDao();
        parent::__construct($dao);
    }
    
    public function getByOrderDetailsId($id) {
        return $this->dao->getById($id);
    }

    public function getByProductId($product_id) {
        $product = $this->dao->getByProductId($product_id);
        if(empty($product)) {
            throw new Exception("Product with this ID does not exist!");
        }
        return $product;
    }

    public function getByOrderId($order_id) {
        $order = $this->dao->getByOrderId($order_id);
        if(empty($order)) {
            throw new Exception("Order with this ID does not exist!");
        }
        return $order;
    }

    public function getByAdminId($admin_id) {
        $admin = $this->dao->getByAdminId($admin_id);
        if(empty($admin)) {
            throw new Exception("No orders found for this Admin ID!");
        }
        return $admin;
    }

    public function validateQuantity($requested_quantity) {
        if($requested_quantity<0) {
            throw new Exception("Quantity must be greater than 0!");
        }
        if($requested_quantity>20) {
            throw new Exception("You cannot order more than 20 units of the same product in a single order!");
        }
        return true;
    }

    public function createOrderDetail($data) {
        $this->validateQuantity($data['quantity']);
        $stock = $this->productDao->getStockByProductId($data['product_id']);
        if($data['quantity']>$stock) {
            throw new Exception("Requested quantity exceeds available stock. Available: $stock");
        }
        return $this->dao->insert($data);
    }
}
?>