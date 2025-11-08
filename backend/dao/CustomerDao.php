<?php
require_once __DIR__ . '/BaseDao.php';


class CustomerDao extends BaseDao {
    public function __construct() {
        parent::__construct("customers");
    }
    public function getByCustomerEmail($email) {
      $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
       $stmt->bindParam(':email', $email);
       $stmt->execute();
       return $stmt->fetchAll();
    }
}
?>
