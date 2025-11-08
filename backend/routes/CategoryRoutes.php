<?php
/**
 * @OA\Get(
 *      path="/category",
 *      tags={"categories"},
 *      summary="Get all categories",
 *      @OA\Response(
 *           response=200,
 *           description="Array of all categories in the database"
 *      )
 * )
 */
Flight::route('GET /category', function(){
    Flight::json(Flight::categoryService()->getAll());
});

/**
 * @OA\Get(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Get category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the category",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the category with the given ID"
 *     )
 * )
 */
Flight::route('GET /category/@id', function($id){ 
    Flight::json(Flight::categoryService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/category/name/{category_name}",
 *     tags={"categories"},
 *     summary="Get category by name",
 *     @OA\Parameter(
 *         name="category_name",
 *         in="path",
 *         required=true,
 *         description="Names of the categories",
 *         @OA\Schema(type="string", example="Lilies")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the category with the given name"
 *     )
 * )
 */
Flight::route('GET /category/name/@category_name', function($category_name){ 
    Flight::json(Flight::categoryService()->getByCategoryName($category_name));
});

/**
 * @OA\Post(
 *     path="/category",
 *     tags={"categories"},
 *     summary="Add a new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"category_name"},
 *             @OA\Property(property="category_name", type="string", example="Lilies")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New category created"
 *     )
 * )
 */
Flight::route('POST /category', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoryService()->insertCategory($data));
});

/**
 * @OA\Put(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Update an existing category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"category_name"},
 *             @OA\Property(property="category_name", type="string", example="Lilies")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated"
 *     )
 * )
 */

Flight::route('PUT /category/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoryService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/category/{id}",
 *     tags={"categories"},
 *     summary="Delete a category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted"
 *     )
 * )
 */
Flight::route('DELETE /category/@id', function($id){
    Flight::json(Flight::categoryService()->deleteCategory($id));
});
?>