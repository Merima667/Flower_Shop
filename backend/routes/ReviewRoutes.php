<?php
/**
 * @OA\Get(
 *      path="/review",
 *      tags={"reviews"},
 *      summary="Get all reviews",
 *      @OA\Response(
 *         response=200,
 *         description="Returns all reviews"
 *      ),
 *      @OA\Response(
 *         response=404,
 *         description="Reviews not found"
 *      )
 * )
 */
Flight::route('GET /review', function(){
    Flight::json(Flight::reviewService()->getAll());
});

/**
 * @OA\Get(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     summary="Get review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the review",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *      @OA\Response(
 *         response=200,
 *         description="Returns the review with a specific id"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review not found"
 *     )
 * )
 */
Flight::route('GET /review/@id', function($id){ 
    Flight::json(Flight::reviewService()->getByReviewId($id));
});

/**
 * @OA\Get(
 *     path="/review/customer/{customer_id}",
 *     tags={"reviews"},
 *     summary="Get reviews of a specific customer",
 *     @OA\Parameter(
 *         name="customer_id",
 *         in="path",
 *         required=true,
 *         description="Customer ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the reviews of a specific customer"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review not found"
 *     )
 * )
 */
Flight::route('GET /review/customer/@customer_id', function($customer_id){ 
    Flight::json(Flight::reviewService()->getReviewsByCustomerId($customer_id));
});

/**
 * @OA\Get(
 *     path="/review/product/{product_id}",
 *     tags={"reviews"},
 *     summary="Get reviews by product ID",
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the reviews of a specific product"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review not found"
 *     )
 * )
 */
Flight::route('GET /review/product/@product_id', function($product_id){ 
    Flight::json(Flight::reviewService()->getByProductId($product_id));
});

/**
 * @OA\Post(
 *     path="/review",
 *     tags={"reviews"},
 *     summary="Insert a new review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "review_description", "customer_id", "product_id"},
 *             @OA\Property(property="name", type="string", example="Merima"),
 *             @OA\Property(property="review_description", type="string", example="The most beautiful bouquet"),
 *             @OA\Property(property="customer_id", type="integer", example=2),
 *             @OA\Property(property="product_id", type="integer", example=2)
 *         )
 *     ),
 *      @OA\Response(
 *         response=200,
 *         description="Review added"
 *      ),
 *      @OA\Response(
 *         response=404,
 *         description="Review cannot be added"
 *      )
 * )
 */
Flight::route('POST /review', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->create($data));
});

/**
 * @OA\Put(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     summary="Update an existing review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the review",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "review_description", "customer_id", "product_id"},
 *             @OA\Property(property="name", type="string", example="Merima"),
 *             @OA\Property(property="review_description", type="string", example="The most beautiful bouqeut"),
 *             @OA\Property(property="customer_id", type="integer", example=4),
 *             @OA\Property(property="product_id", type="integer", example=5)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review updated"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review cannot be updated"
 *     )
 * )
 */

Flight::route('PUT /review/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     summary="Delete a review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the review",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review deleted"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review cannot be deleted"
 *     )
 * )
 */
Flight::route('DELETE /review/@id', function($id){
    Flight::json(Flight::reviewService()->delete($id));
});
?>