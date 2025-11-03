<?php
require_once 'BaseDao.php';


class OrderDao extends BaseDao {
    public function __construct() {
        parent::__construct("orders");
    }
    public function getByOrderId($order_id) {
       return $this->getById($order_id);
    }
    public function insertOrder($data) {
        return $this->insert($data);
    }
    public function updateOrder($order_id, $data) {
        return $this->update($order_id, $data);
    }
    public function deleteOrder($order_id) {
        return $this->delete($order_id);
    }
}
?>
