<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderDao.php';

class OrderService extends BaseService {
    protected $userDao;
    public function __construct() {
        $dao = new OrderDao();
        $this->userDao = new UserDao();
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

    public function getByUserId($user_id) {
        $user = $this->userDao->getById($user_id);
        if(!$user) {
            throw new Exception("User doesn't exist!");
        }
        $orders = $this->dao->getByUserId($user_id);
        if(empty($orders)) {
            throw new Exception("User has no orders!");
        }
        return $orders;
    }
}

?>