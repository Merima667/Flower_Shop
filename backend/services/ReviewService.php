<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';
require_once __DIR__ . '/../dao/UserDao.php';

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
    public function getReviewsByUserId($user_id) {
        $reviews = $this->dao->getReviewByUserId($user_id);
        if(empty($reviews)) {
            throw new Exception("This user has not written any reviews!");
        }
        return $reviews;
    }

    public function addReview($data) {
    if (empty($data['product_id']) || empty($data['review_description']) || empty($data['name'])) {
        throw new Exception("All entries are required!");
    }
    $user_id = $data['user_id'] ?? null; 
    $userDao = new UserDao();
    $user = $userDao->getById($user_id);
    if (!$user) {
        throw new Exception("User not found!");
    }

    if ($user['role'] !== 'customer') {
        throw new Exception("Only customers can write reviews!");
    }
    $data['user_id'] = $user_id;
    $insertedId = $this->dao->insert($data);
    $data['id'] = $insertedId;
    return $data;
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