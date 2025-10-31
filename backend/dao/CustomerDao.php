<?php
require_once 'BaseDao.php';


class CustomerDao extends BaseDao {
    public function __construct() {
        parent::__construct("customers");
    }
    public function getByCustomerId($customer_id) {
        return $this->getById($customer_id);
    }
    public function deleteCustomer($customer_id) {
        return $this->delete($customer_id);
    }
    public function insertCustomer($data) {
        return $this->insert($data);
    }
}
?>
