<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AdminDao.php';

class AdminService extends BaseService {
    public function __construct() {
        $dao = new AdminDao();
        parent::__construct($dao);
    }

    public function getByAdminId($id) {
        $admin = $this->dao->getAdminById($id);
        if(!$admin) {
            throw new Exception("Admin with ID $id doesn't exist!");
        }
        return $admin;
    }

    public function getByAdminEmail($email) {
        $admin = $this->dao->getByAdminEmail($email);
        if(!$admin) {
            throw new Exception("Admin with email $email doesn't exist!");
        }
        return $admin;
    }
}

?>