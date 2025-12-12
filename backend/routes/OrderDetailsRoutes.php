<?php
/**
 * @OA\Get(
 *      path="/orderDetail",
 *      tags={"orderDetails"},
 *      security={
 *         {"ApiKey": {}}
 *      },
 *      summary="Get all order details",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all order details in the database"
 *      )
 * )
 */
Flight::route('GET /orderDetail', function(){
    Flight::auth_middleware()->authorizeRole(Roles::USER);
    Flight::json(Flight::orderDetailsService()->getAll());
});

/**
 * @OA\Get(
 *     path="/orderDetail/{id}",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Get order details by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the orderDetails",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order details with the given ID"
 *     )
 * )
 */
Flight::route('GET /orderDetail/@id', function($id){ 
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderDetailsService()->getByOrderDetailsId($id));
});

/**
 * @OA\Get(
 *     path="/orderDetail/product/{id}",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Get order details  for a single product by product ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the product",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order details for a single product with the given product ID"
 *     )
 * )
 */
Flight::route('GET /orderDetail/product/@id', function($id){ 
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderDetailsService()->getByProductId($id));
});

/**
 * @OA\Get(
 *     path="/orderDetail/order/{id}",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Get order details  for a single order by order ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the order",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order details for a single order with the given order ID"
 *     )
 * )
 */
Flight::route('GET /orderDetail/order/@id', function($id){ 
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderDetailsService()->getByOrderId($id));
});

/**
 * @OA\Get(
 *     path="/orderDetail/user/{id}",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Get order details by User ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order details  with the given admin ID"
 *     )
 * )
 */
Flight::route('GET /orderDetail/user/@id', function($id){ 
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderDetailsService()->getByUserId($id));
});

/**
 * @OA\Post(
 *     path="/orderDetail",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Insert a new order details",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"quantity", "product_id", "order_id", "admin_id"},
 *             @OA\Property(property="quantity", type="integer", example=5),
 *             @OA\Property(property="product_id", type="integer", example=2),
 *             @OA\Property(property="order_id", type="integer", example=2),
 *             @OA\Property(property="user_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New order details added"
 *     )
 * )
 */
Flight::route('POST /orderDetail', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderDetailsService()->createOrderDetail($data));
});

/**
 * @OA\Put(
 *     path="/orderDetail/{id}",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Update an existing order details by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order details ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"quantity", "product_id", "order_id", "admin_id"},
 *             @OA\Property(property="quantity", type="integer", example=5),
 *             @OA\Property(property="product_id", type="integer", example=2),
 *             @OA\Property(property="order_id", type="integer", example=2),
 *             @OA\Property(property="user_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order details updated"
 *     )
 * )
 */

Flight::route('PUT /orderDetail/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderDetailsService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/orderDetail/{id}",
 *     tags={"orderDetails"},
 *     security={
 *         {"ApiKey": {}}
 *      },
 *     summary="Delete an order details by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order details ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order details deleted"
 *     )
 * )
 */
Flight::route('DELETE /orderDetail/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderDetailsService()->delete($id));
});
?>