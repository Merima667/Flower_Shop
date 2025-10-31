<?php
require_once 'BaseDao.php';

class AdminDao extends BaseDao {
    public function __construct() {
        parent::__construct("admins");
    }
    public function getByAdminId($admin_id) {
        return $this->getById($admin_id);
    }
    public function insertAdmin($data) {
        return $this->insert($data);
    }
    public function updateAdmin($admin_id,$data) {
        return $this->update($admin_id, $data);
    }
    public function deleteAdmin($admin_id) {
        return $this->delete($admin_id);
    }
}
?>
