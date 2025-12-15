<?php
require_once __DIR__ . '/BaseDao.php';


class ReviewDao extends BaseDao {
   public function __construct() {
      parent::__construct("reviews");
   }
   public function getByReviewId($review_id) {
      return $this->getById($review_id);
   }
   public function getReviewByUserId($user_id) {
      $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE user_id = :user_id");
      $stmt->bindParam(':user_id', $user_id);
      $stmt->execute();
      return $stmt->fetchAll();
   }
   public function getByProductId($product_id) {
      $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE product_id = :product_id");
      $stmt->bindParam(':product_id', $product_id);
      $stmt->execute();
      return $stmt->fetchAll();
   }
}
?>