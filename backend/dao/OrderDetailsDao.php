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
        return $stmt->fetchAll();
    }

    public function getByAdminId($admin_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $admin_id);
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