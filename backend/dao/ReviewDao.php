<?php
require_once 'BaseDao.php';


class ReviewDao extends BaseDao {
   public function __construct() {
      parent::__construct("reviews");
   }
   public function getByReviewId($review_id) {
      return $this->getById($review_id);
   }
   public function insertReview($data) {
      return $this->insert($data);
   }
   public function deleteReview($review_id) {
      return $this->delete(review_id);
   }
}
?>