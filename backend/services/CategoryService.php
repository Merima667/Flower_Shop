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
        if (empty($data['category_name'])) {
            throw new Exception("Category name is required");
        }
        $existing = $this->getByCategoryName($data['category_name']);
        if(!empty($existing)) {
            throw new Exception('Category already exists!');
        }
        $data['description'] = $data['description'] ?? null;
        return $this->create($data);
    }

    public function update($id, $data) {
        $existing = $this->getById($id);
        if (empty($existing)) {
            throw new Exception("Category doesn't exist");
        }
        if (empty($data['category_name'])) {
            throw new Exception("Category name is required");
        }
        $data['description'] = $data['description'] ?? $existing['description'];
        return parent::update($id, $data);
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