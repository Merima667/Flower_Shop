<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService extends BaseService {
    public function __construct() {
        $dao = new CategoryDao();
        parent::__construct($dao);
    }
    
    public function getByCategoryName($category_name) {
        return $this->dao->getByCategoryName($category_name);
    }

    public function insertCategory($data) {
        $existing = $this->getByCategoryName($data['category_name']);
        if(!empty($existing)) {
            throw new Exception('Category already exists!');
        }
        return $this->create($data);
    }

    public function deleteCategory($id) {
        $existing = $this->getById($id);
        if(empty($existing)) {
            throw new Exception("Category doesn't exist");
        }
        return $this->delete($id);
    }
}

?>