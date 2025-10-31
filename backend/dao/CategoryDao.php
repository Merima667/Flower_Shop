<?php
require_once 'BaseDao.php';


class CategoryDao extends BaseDao {
   public function __construct() {
      parent::__construct("categories");
   }
   public function getByCategoryId($category_id) {
      return $this->getById($category_id);
   }
   public function getByCategoryName($category_name) {
      $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE category_name = :category_name");
       $stmt->bindParam(':category_name', $category_name);
       $stmt->execute();
       return $stmt->fetchAll();
   }
   public function insertCategory($data) {
      return $this->insert($data);
   }
   public function deleteCategory($category_id) {
      return $this->delete($category_id);
   }
}
?>