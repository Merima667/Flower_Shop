<?php
require_once __DIR__ . '/BaseDao.php';


class OrderDao extends BaseDao {
    public function __construct() {
        parent::__construct("orders");
    }
    public function getByOrderId($order_id) {
       return $this->getById($order_id);
    }
    public function getByOrderDate($order_date) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE order_date = :order_date");
        $stmt->bindParam(':order_date', $order_date);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByOrderStatus($status) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE status = :status");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByCustomerId($customer_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
