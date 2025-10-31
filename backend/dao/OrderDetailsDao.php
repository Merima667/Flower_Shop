<?php
require_once 'BaseDao.php';


class OrderDetailsDao extends BaseDao {
    public function __construct() {
        parent::__construct("orderdetails");
    }
    public function getByOrderDetailsId($orderDetails_id) {
        return $this->getById($orderDetails_id);
    }
    public function getByOrderId($order_id) {
        return $this->getById($order_id);
    } 
    public function insertOrderDetails($data) {
        return $this->insert($data);
    }
    public function deleteOrderDetails($orderDetails_id) {
        return $this->delete($orderDetails_id);
    }
}
?>