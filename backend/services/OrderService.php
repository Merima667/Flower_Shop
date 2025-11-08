<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderDao.php';
require_once __DIR__ . '/../dao/CustomerDao.php';

class OrderService extends BaseService {
    protected $customerDao;
    public function __construct() {
        $dao = new OrderDao();
        $this->customerDao = new CustomerDao();
        parent::__construct($dao);
    }
    
    public function getByOrderId($id) {
        return $this->dao->getByOrderId($id);
    }

    public function getOrdersByOrderDate($order_date) {
        $today = date('Y-m-d');
        if($order_date>$today) {
            throw new Exception("Order date cannot be in the future!");
        }
        return $this->dao->getByOrderDate($order_date);
    }

    public function getByOrderStatus($status) {
        $status = strtolower($status);
        $existing_status = ['pending', 'shipped', 'delivered','cancelled'];
        if(!in_array($status, $existing_status)) {
            throw new Exception("Invalid status: $status");
        }
        return $this->dao->getByOrderStatus($status);
    }

    public function getByCustomerId($customer_id) {
        $customer = $this->customerDao->getById($customer_id);
        if(!$customer) {
            throw new Exception("Customer doesn't exist!");
        }
        $orders = $this->dao->getByCustomerId($customer_id);
        if(empty($orders)) {
            throw new Exception("Customer has no orders!");
        }
        return $orders;
    }
}

?>