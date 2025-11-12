<?php
require_once  __DIR__ . '/BaseDao.php';

class AdminDao extends BaseDao {
    public function __construct() {
        parent::__construct("admins");
    }
    public function getAdminById($admin_id) {
        return $this->getById($admin_id);
    }
    public function getByAdminEmail($email) {
         $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
       $stmt->bindParam(':email', $email);
       $stmt->execute();
       return $stmt->fetch();
    }
}
?>
