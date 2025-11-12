<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CustomerDao.php';

class CustomerService extends BaseService {
    public function __construct() {
        $dao = new CustomerDao();
        parent::__construct($dao);
    }
    
    public function getByCustomerId($id) {
        return $this->dao->getById($id);
    }
    public function getByCustomerEmail($email) {
        $customer = $this->dao->getByCustomerEmail($email);
        if(!$customer) {
            throw new Exception("Customer with email $email doesn't exist!");
        }
        return $customer;
    }
    public function registerCustomer($data) {
        $existing = $this->dao->getByCustomerEmail($data['email']);
        if($existing) {
            throw new Exception("Customer with this email address already exists");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }

    public function deleteCustomer($id) {
        $existing = $this->getById($id);
        if(empty($existing)) {
            throw new Exception("Customer doesn't exists");
        }
        return $this->delete($id);
    }
}

?>