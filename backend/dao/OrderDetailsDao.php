<?php
require_once __DIR__ . '/BaseDao.php';


class OrderDetailsDao extends BaseDao {
    public function __construct() {
        parent::__construct("orderdetails");
    }
    public function getByProductId($product_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByOrderId($order_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        error_log("DEBUG DAO getByOrderId($order_id): " . json_encode($result));
        return $result;
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getQuantityByProduct($product_id) {
        $stmt = $this->connection->prepare("SELECT quantity FROM " . $this->table . " WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? (int)$result['quantity'] : 0;
    }
}
?>