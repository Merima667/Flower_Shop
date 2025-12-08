<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService {
    
    public function __construct() {
        $dao = new UserDao();
        parent::__construct($dao);
    }

    public function getByUserId($id) {
        $user = $this->dao->getByUserId($id);
        if(!$user) {
            throw new Exception("User with ID $id does not exist!");
        }
        return $user;
    }

    public function getByEmail($email) {
        $user = $this->dao->getByEmail($email);
        if(!$user) {
            throw new Exception("User with email $email does not exist!");
        }
        return $user;
    }

    public function getUsersByRole($role) {
        $valid_roles = ['admin', 'customer'];
        if(!in_array($role, $valid_roles)) {
            throw new Exception("Invalid role: $role");
        }
        return $this->dao->getByRole($role);
    }

    public function createUser($data) {
        if(empty($data['email']) || empty($data['password'])) {
            throw new Exception("Email and password are required to create a user.");
        }

        $existing = $this->dao->getByEmail($data['email']);
        if($existing) {
            throw new Exception("Email {$data['email']} is already registered!");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->dao->insertUser($data);
    }

    public function updateUser($id, $data) {
        if(isset($data['email'])) {
            $existing = $this->dao->getByEmail($data['email']);
            if($existing && $existing['id'] != $id) {
                throw new Exception("Email {$data['email']} is already taken by another user!");
            }
        }

        if(isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        return $this->dao->updateUser($id, $data);
    }

    public function deleteUser($id) {
        $user = $this->dao->getByUserId($id);
        if(!$user) {
            throw new Exception("Cannot delete: User with ID $id does not exist!");
        }
        return $this->dao->deleteUser($id);
    }
}
?>
