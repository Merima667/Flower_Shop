<?php
/**
 * @OA\Get(
 *      path="/order",
 *      tags={"orders"},
 *      summary="Get all orders",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all orders in the database"
 *      )
 * )
 */
Flight::route('GET /order', function(){
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getAll());
});

/**
 * @OA\Get(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     summary="Get orders by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the order",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the order with the given ID"
 *     )
 * )
 */
Flight::route('GET /order/@id', function($id){ 
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getByOrderId($id));
});

/**
 * @OA\Get(
 *     path="/order/date/{order_date}",
 *     tags={"orders"},
 *     summary="Get orders for a specific date by order date",
 *     @OA\Parameter(
 *         name="order_date",
 *         in="path",
 *         required=true,
 *         description="Date of the order",
 *         @OA\Schema(type="string", format = "date", example='2025-10-20')
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the orders for a specific date with the given order date"
 *     )
 * )
 */
Flight::route('GET /order/date/@order_date', function($order_date){ 
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getOrdersByOrderDate($order_date));
});

/**
 * @OA\Get(
 *     path="/order/status/{status}",
 *     tags={"orders"},
 *     summary="Get orders by order status",
 *     @OA\Parameter(
 *         name="status",
 *         in="path",
 *         required=true,
 *         description="Status of the order",
 *         @OA\Schema(type="string", example='pending')
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the orders for a single status"
 *     )
 * )
 */
Flight::route('GET /order/status/@status', function($status){ 
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getByOrderStatus($status));
});

/**
 * @OA\Get(
 *     path="/order/user/{user_id}",
 *     tags={"orders"},
 *     summary="Get orders by user id",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the orders for a single user"
 *     )
 * )
 */
Flight::route('GET /order/user/@user_id', function($user_id){ 
    Flight::auth_middleware()->authorizeRole([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getByUserId($user_id));
});

/**
 * @OA\Post(
 *     path="/order",
 *     tags={"orders"},
 *     summary="Insert a new order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_date", "status", "total", "customer_id"},
 *             @OA\Property(property="order_date", type="string",format = "date", example="2025-10-8"),
 *             @OA\Property(property="status", type="string", example="Pending"),
 *             @OA\Property(property="total", type="number",format = "float", example=50.2),
 *             @OA\Property(property="user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New order added"
 *     )
 * )
 */
Flight::route('POST /order', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderService()->create($data));
});

/**
 * @OA\Put(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     summary="Update an existing order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_date", "status", "total", "user_id"},
 *             @OA\Property(property="order_date", type="string",format = "date", example="2025-10-8"),
 *             @OA\Property(property="status", type="string", example="Pending"),
 *             @OA\Property(property="total", type="number",format = "float", example=50.2),
 *             @OA\Property(property="user_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated"
 *     )
 * )
 */

Flight::route('PUT /order/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::orderService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     summary="Delete an order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order deleted"
 *     )
 * )
 */
Flight::route('DELETE /order/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderService()->delete($id));
});
?>