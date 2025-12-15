<?php
/**
 * @OA\Get(
 *      path="/public/review",
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
Flight::route('GET /public/review', function(){
    Flight::json(Flight::reviewService()->getAll());
});

/**
 * @OA\Get(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::reviewService()->getByReviewId($id));
});

/**
 * @OA\Get(
 *     path="/review/user/{user_id}",
 *     tags={"reviews"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Get reviews of a specific user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the reviews of a specific user"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review not found"
 *     )
 * )
 */
Flight::route('GET /review/user/@user_id', function($user_id){ 
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::reviewService()->getReviewsByUserId($user_id));
});

/**
 * @OA\Get(
 *     path="/public/review/product/{product_id}",
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
Flight::route('GET /public/review/product/@product_id', function($product_id){ 
    Flight::json(Flight::reviewService()->getByProductId($product_id));
});

/**
 * @OA\Post(
 *     path="/review",
 *     tags={"reviews"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Insert a new review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "review_description", "user_id", "product_id"},
 *             @OA\Property(property="name", type="string", example="Merima"),
 *             @OA\Property(property="review_description", type="string", example="The most beautiful bouquet"),
 *             @OA\Property(property="user_id", type="integer", example=1),
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
    Flight::auth_middleware()->authorizeRole(Roles::USER);
    $data = Flight::request()->data->getData();
    $data['user_id'] = Flight::get('user')->id;
    Flight::json(Flight::reviewService()->create($data));
});

/**
 * @OA\Put(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
 *             required={"name", "review_description", "user_id", "product_id"},
 *             @OA\Property(property="name", type="string", example="Merima"),
 *             @OA\Property(property="review_description", type="string", example="The most beautiful bouqeut"),
 *             @OA\Property(property="user_id", type="integer", example=2),
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
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/review/{id}",
 *     tags={"reviews"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::reviewService()->delete($id));
});
?>