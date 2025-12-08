<?php
require_once __DIR__ . '/BaseDao.php';


class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct("products");
    }
    public function getByProductId($product_id) {
        return $this->getById($product_id);
    }
    public function getByCategoryId($category_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE category_id = :category_id");
      $stmt->bindParam(':category_id', $category_id);
      $stmt->execute();
      return $stmt->fetchAll();
    }
    public function getByUserId($admin_id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getByProductName($product_name) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE product_name = :product_name");
        $stmt->bindParam(':product_name', $product_name);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getStockByProductId($id) {
        $stmt = $this->connection->prepare("SELECT stock FROM " . $this->table . " WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? (int)$result['stock'] : 0;
    }
}
?>