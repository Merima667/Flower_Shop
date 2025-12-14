<?php
/**
 * @OA\Get(
 *      path="/order",
 *      tags={"orders"},
 *      security={
 *         {"ApiKey": {}}
 *      },
 *      summary="Get all orders",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all orders in the database"
 *      )
 * )
 */
Flight::route('GET /order', function(){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getAll());
});

/**
 * @OA\Get(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     security={
 *         {"ApiKey": {}}
 *      },  
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
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getByOrderId($id));
});

/**
 * @OA\Get(
 *     path="/order/date/{order_date}",
 *     tags={"orders"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getOrdersByOrderDate($order_date));
});

/**
 * @OA\Get(
 *     path="/order/status/{status}",
 *     tags={"orders"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::orderService()->getByOrderStatus($status));
});

/**
 * @OA\Get(
 *     path="/order/user/{user_id}",
 *     tags={"orders"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::orderService()->getByUserId($user_id));
});

/**
 * @OA\Get(
 *     path="/order/user",
 *     tags={"orders"},
 *     security={{"ApiKey": {}}},
 *     summary="Get all orders for the logged-in user",
 *     @OA\Response(
 *         response=200,
 *         description="Returns all orders of the currently logged-in user"
 *     )
 * )
 */
Flight::route('GET /order/user', function(){
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $user = Flight::get('user'); 
    $userId = $user->id;
    Flight::json(Flight::orderService()->getByUserId($userId));
});

/**
 * @OA\Post(
 *     path="/order",
 *     tags={"orders"},
 *     security={{"ApiKey": {}}},
 *     summary="Insert a new order with details",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "delivery_address", "product_id", "quantity", "price"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="delivery_address", type="string", example="Sarajevo, Bosnia"),
 *             @OA\Property(property="product_id", type="integer", example=38),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="price", type="number", format="float", example=25.5)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order created successfully")
 * )
 */
Flight::route('POST /order', function(){
    Flight::auth_middleware()->authorizeRole(Roles::USER);

    $data = Flight::request()->data->getData();
    error_log("DEBUG DATA: " . json_encode($data));
    
    $user_id = Flight::get('user')->id; 
    $delivery_address = $data['delivery_address'] ?? '';
    $product_id = $data['product_id'] ?? null;
    $quantity = $data['quantity'] ?? 1;
    if (!$product_id) {
        throw new Exception("Product ID is missing!");
    }
    
    $product = Flight::productService()->getByProductId($product_id);
    $price = $product['price'];

    $order_id = Flight::orderService()->createOrderWithDetails(
        $user_id,
        $delivery_address,
        $product_id,
        $quantity,
        $price
    );

    Flight::json([
        'message' => 'Order placed successfully', 
        'order_id' => $order_id
    ]);
});



/**
 * @OA\Put(
 *     path="/order/{id}",
 *     tags={"orders"},
 *     security={
 *         {"ApiKey": {}}
 *      },
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
 *     security={
 *         {"ApiKey": {}}
 *      },
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