<?php
require_once 'BaseDao.php';


class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct("products");
    }
    public function getByProductId($product_id) {
        return $this->getById($product_id);
    }
    public function getByCategoryId($category_id) {
        return $this->getById($category_id);
    }
    public function insertProduct($data) {
        return $this->insert($data);
    }
}
?>