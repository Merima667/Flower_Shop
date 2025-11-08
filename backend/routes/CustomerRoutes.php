<?php
/**
 * @OA\Get(
 *      path="/customer",
 *      tags={"customers"},
 *      summary="Get all customers",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all customers in the database"
 *      )
 * )
 */
Flight::route('GET /customer', function(){
    Flight::json(Flight::customerService()->getAll());
});

/**
 * @OA\Get(
 *     path="/customer/{id}",
 *     tags={"customers"},
 *     summary="Get customer by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the customer",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the customer with the given ID"
 *     )
 * )
 */
Flight::route('GET /customer/@id', function($id){ 
    Flight::json(Flight::customerService()->getByCustomerId($id));
});

/**
 * @OA\Get(
 *     path="/customer/email/{email}",
 *     tags={"customers"},
 *     summary="Get customer by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="Customer selected by email",
 *         @OA\Schema(type="string", example="selma.melunovic05@gmail.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the customer with the given email"
 *     )
 * )
 */
Flight::route('GET /customer/email/@email', function($email){ 
    Flight::json(Flight::customerService()->getByCustomerEmail($email));
});

/**
 * @OA\Post(
 *     path="/customer/register",
 *     tags={"customers"},
 *     summary="Register a new customer",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "surname", "email", "password"},
 *             @OA\Property(property="name", type="string", example="Selma"),
 *             @OA\Property(property="surname", type="string", example="Melunovic"),
 *             @OA\Property(property="email", type="string", example="selma.melunovic05@gmail.com"),
 *             @OA\Property(property="password", type="string", example="54321")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New customer created"
 *     )
 * )
 */
Flight::route('POST /customer/register', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::customerService()->registerCustomer($data));
});

/**
 * @OA\Put(
 *     path="/customer/{id}",
 *     tags={"customers"},
 *     summary="Update an existing customer by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Customer ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "surname", "email", "password"},
 *             @OA\Property(property="name", type="string", example="Selma"),
 *             @OA\Property(property="surname", type="string", example="Melunovic"),
 *             @OA\Property(property="email", type="string", example="selma1.melunovic05@gmail.com"),
 *             @OA\Property(property="password", type="string", example="54322")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Customer updated"
 *     )
 * )
 */

Flight::route('PUT /customer/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::customerService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/customer/{id}",
 *     tags={"customers"},
 *     summary="Delete a customer by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Customer ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Customer deleted"
 *     )
 * )
 */
Flight::route('DELETE /customer/@id', function($id){
    Flight::json(Flight::customerService()->deleteCustomer($id));
});
?>