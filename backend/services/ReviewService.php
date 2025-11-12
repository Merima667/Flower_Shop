<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService extends BaseService {
    public function __construct() {
        $dao = new ReviewDao();
        parent::__construct($dao);
    }
    public function getByReviewId($review_id) {
        $review = $this->dao->getByReviewId($review_id);
        if(!$review) {
            throw new Exception("Review with ID $review_id not found!");
        }
        return $review;
    }
    public function getReviewsByCustomerId($customer_id) {
        $reviews = $this->dao->getReviewByCustomerId($customer_id);
        if(empty($reviews)) {
            throw new Exception("This customer has not written any reviews!");
        }
        return $reviews;
    }
    public function getByProductId($product_id) {
        $reviews = $this->dao->getByProductId($product_id);
        if(empty($reviews)) {
            throw new Exception("There is not review for this product!");
        }
        return $reviews;
    }
}
?>