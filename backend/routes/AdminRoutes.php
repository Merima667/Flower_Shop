<?php
/**
 * @OA\Get(
 *      path="/admin",
 *      tags={"admins"},
 *      summary="Get all admins",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all admins in the database"
 *      )
 * )
 */
Flight::route('GET /admin', function(){
    Flight::json(Flight::adminService()->getAll());
});

/**
 * @OA\Get(
 *     path="/admin/{id}",
 *     tags={"admins"},
 *     summary="Get admin by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the admin",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the admin with the given ID"
 *     )
 * )
 */
Flight::route('GET /admin/@id', function($id){ 
    Flight::json(Flight::adminService()->getByAdminId($id));
});

/**
 * @OA\Get(
 *     path="/admin/email/{email}",
 *     tags={"admins"},
 *     summary="Get admin by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="Email of the admin",
 *         @OA\Schema(type="string", example="merima.balihodzic@gmail.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the admin with the given Email"
 *     )
 * )
 */
Flight::route('GET /admin/email/@email', function($email){ 
    Flight::json(Flight::adminService()->getByAdminEmail($email));
});

/**
 * @OA\Post(
 *     path="/admin",
 *     tags={"admins"},
 *     summary="Add a new admin",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "surname", "email", "password"},
 *             @OA\Property(property="name", type="string", example="Sara"),
 *             @OA\Property(property="surname", type="string", example="Mesic"),
 *             @OA\Property(property="email", type="string", example="sara.mesic@gmail.com"),
 *             @OA\Property(property="password", type="string", example="12345")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New admin created"
 *     )
 * )
 */
Flight::route('POST /admin', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::adminService()->insert($data));
});

/**
 * @OA\Put(
 *     path="/admin/{id}",
 *     tags={"admins"},
 *     summary="Update an existing admin by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Admin ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "surname", "email", "password"},
 *             @OA\Property(property="name", type="string", example="Sara"),
 *             @OA\Property(property="surname", type="string", example="Mesic"),
 *             @OA\Property(property="email", type="string", example="sara.mesic@gmail.com"),
 *             @OA\Property(property="password", type="string", example="12345")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Admin updated"
 *     )
 * )
 */

Flight::route('PUT /admin/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::adminService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/admin/{id}",
 *     tags={"admins"},
 *     summary="Delete an admin by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Admin ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Admin deleted"
 *     )
 * )
 */
Flight::route('DELETE /admin/@id', function($id){
    Flight::json(Flight::adminService()->delete($id));
});
?>