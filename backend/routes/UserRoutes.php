<?php

/**
 * @OA\Get(
 *      path="/user",
 *      tags={"users"},
 *      summary="Get all users",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all users in the database"
 *      )
 * )
 */
Flight::route('GET /user', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::userService()->getAll());
});

/**
 * @OA\Get(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the user with the given ID"
 *     )
 * )
 */
Flight::route('GET /user/@id', function($id){ 
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::userService()->getByUserId($id));
});

/**
 * @OA\Get(
 *     path="/user/email/{email}",
 *     tags={"users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="Email of the user",
 *         @OA\Schema(type="string", example="user@example.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the user with the given email"
 *     )
 * )
 */
Flight::route('GET /user/email/@email', function($email){ 
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::userService()->getByEmail($email));
});

/**
 * @OA\Get(
 *     path="/user/role/{role}",
 *     tags={"users"},
 *     summary="Get users by role",
 *     @OA\Parameter(
 *         name="role",
 *         in="path",
 *         required=true,
 *         description="Role of the users (e.g., admin, customer)",
 *         @OA\Schema(type="string", example="customer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns all users with the given role"
 *     )
 * )
 */
Flight::route('GET /user/role/@role', function($role){ 
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::userService()->getUsersByRole($role));
});

/**
 * @OA\Post(
 *     path="/user",
 *     tags={"users"},
 *     summary="Insert a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password", "role"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="secret123"),
 *             @OA\Property(property="role", type="string", example="customer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New user added"
 *     )
 * )
 */
Flight::route('POST /user', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->createUser($data));
});

/**
 * @OA\Put(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Update an existing user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="user@example1.com"),
 *             @OA\Property(property="password", type="string", example="newpassword"),
 *             @OA\Property(property="role", type="string", example="admin")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated"
 *     )
 * )
 */
Flight::route('PUT /user/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->updateUser($id, $data));
});

/**
 * @OA\Delete(
 *     path="/user/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted"
 *     )
 * )
 */
Flight::route('DELETE /user/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::userService()->deleteUser($id));
});

?>
