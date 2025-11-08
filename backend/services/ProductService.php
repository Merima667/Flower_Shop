<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ProductDao.php';

class ProductService extends BaseService {
    public function __construct() {
        $dao = new ProductDao();
        parent::__construct($dao);
    }
    public function getByProductId($product_id) {
        $product = $this->dao->getByProductId($product_id);
        if(!$product) {
            throw new Exception("Product with ID $product_id not found!");
        }
        return $product;
    }
    public function getByProductName($product_name) {
        $products = $this->dao->getByProductName($product_name);
        if(empty($products)) {
        throw new Exception("No products found with name '$product_name'");
        }
        return $products;
    }
    public function getByCategoryId($category_id) {
        $products = $this->dao->getById($category_id);
        if(empty($products)) {
        throw new Exception("No products found in this category.");
        }
        return $products;
    }
    public function checkStock($product_id) {
        $stock = $this->dao->getStockByProductId($product_id);
        if($stock==0) {
            throw new Exception("Product is out of stock!");
        }
        return $stock;
    }
    public function createProduct($data) {
        $existingProduct = $this->dao->getByProductName($data['product_name']);
        if (!empty($existingProduct)) {
            throw new Exception("Product with this name already exists!");
        }
        if($existingProduct) {
            throw new Exception("Product already exists, you csn only update it!");
        }
        if ($data['stock'] < 0) {
            throw new Exception("Stock cannot be negative.");
        }
        if (empty($data['product_name'])) {
            throw new Exception("Product name is required.");
        }
        return parent::create($data);
    }
}
?>