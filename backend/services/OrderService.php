<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderDao.php';
require_once __DIR__ . '/OrderDetailsService.php';

class OrderService extends BaseService {
    protected $userDao;
    protected $orderDetailsService;
    public function __construct() {
        $dao = new OrderDao();
        $this->userDao = new UserDao();
        $this->orderDetailsService = new OrderDetailsService();
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
            return [];
        }

        foreach($orders as &$order) {
            error_log("DEBUG order: " . json_encode($order)); 
            $details = $this->orderDetailsService->getByOrderId($order['id']);
            error_log("DEBUG details: " . json_encode($details)); 

            $total = 0;
            if(is_array($details)) {
                foreach($details as $d) {
                    $total += isset($d['total']) ? $d['total'] : 0;
                }
            }
            $order['total'] = $total;
        }

        return $orders;
    }

    public function createOrderWithDetails($user_id, $delivery_address, $product_id, $quantity, $price) {
        if(!$user_id) {
            throw new Exception("user_id is required");
        }
        if(!$product_id) {
            throw new Exception("product_id is required");
        }
    
        $orderData = [
        'user_id' => $user_id,
        'delivery_address' => $delivery_address,
        'order_date' => date('Y-m-d'),
        'status' => 'pending'
    ];

    $createdOrder = $this->dao->add($orderData);
    $orderId = $createdOrder['id'];

    $orderDetailsData = [
        'order_id' => $orderId,
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price,
        'total' => $price * $quantity
    ];

    $this->orderDetailsService->createOrderDetail($orderDetailsData);

    return $orderId;
}
}

?>