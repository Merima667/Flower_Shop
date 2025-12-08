<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {

    public function __construct() {
        parent::__construct("users");
    }

    public function getByUserId($user_id) {
        return $this->getById($user_id);
    }

    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByRole($role) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE role = :role");
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertUser($data) {
        return $this->insert($data);
    }

    public function updateUser($user_id, $data) {
        return $this->update($user_id, $data);
    }

    public function deleteUser($user_id) {
        return $this->delete($user_id);
    }
}
?>
