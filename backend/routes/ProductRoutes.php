<?php
/**
 * @OA\Get(
 *      path="/product",
 *      tags={"products"},
 *      summary="Get all products",
 *      @OA\Response(
 *         response=200,
 *         description="Returns all products"
 *      ),
 *      @OA\Response(
 *         response=404,
 *         description="Products not found"
 *      )
 * )
 */
Flight::route('GET /product', function(){
    Flight::json(Flight::productService()->getAll());
});

/**
 * @OA\Get(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Get products by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the product",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *      @OA\Response(
 *         response=200,
 *         description="Returns the products with a specific id"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 */
Flight::route('GET /product/@id', function($id){ 
    Flight::json(Flight::productService()->getByProductId($id));
});

/**
 * @OA\Get(
 *     path="/product/name/{name}",
 *     tags={"products"},
 *     summary="Get products of a specific name",
 *     @OA\Parameter(
 *         name="name",
 *         in="path",
 *         required=true,
 *         description="Name of the product",
 *         @OA\Schema(type="string", example='Tulips')
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the products with a specific name"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 */
Flight::route('GET /product/name/@name', function($name){ 
    Flight::json(Flight::productService()->getByProductName($name));
});

/**
 * @OA\Get(
 *     path="/product/category/{category_id}",
 *     tags={"products"},
 *     summary="Get products by category ID",
 *     @OA\Parameter(
 *         name="category_id",
 *         in="path",
 *         required=true,
 *         description="Category ID for the order",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the products of a specific category"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 */
Flight::route('GET /product/category/@category_id', function($category_id){ 
    Flight::json(Flight::productService()->getByCategoryId($category_id));
});

/**
 * @OA\Get(
 *     path="/product/stock/{product_id}",
 *     tags={"products"},
 *     summary="Check stock for a specific product",
 *     @OA\Parameter(
 *         name="product_id",
 *         in="path",
 *         required=true,
 *         description="ID of the product",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *      @OA\Response(
 *         response=200,
 *         description="Returns the products for a specific category"
 *      ),
 *      @OA\Response(
 *         response=404,
 *         description="Product not found"
 *      )
 * )
 */
Flight::route('GET /product/stock/@product_id', function($product_id){ 
    Flight::json(Flight::productService()->checkStock($product_id));
});

/**
 * @OA\Post(
 *     path="/product",
 *     tags={"products"},
 *     summary="Insert a new product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_name", "price", "image_url", "category_id", "admin_id", "stock"},
 *             @OA\Property(property="product_name", type="string", example="White lilies"),
 *             @OA\Property(property="price", type="number", format="float", example=45.5),
 *             @OA\Property(property="image_url", type="string", example="/frontend/assets/FB69VCP_LOL_preset_proflowers-mx-tile-wide-sv-new.webp"),
 *             @OA\Property(property="category_id", type="integer", example=2),
 *             @OA\Property(property="admin_id", type="integer", example=3),
 *             @OA\Property(property="stock", type="integer", example=15)
 *         )
 *     ),
 *      @OA\Response(
 *         response=200,
 *         description="Product added"
 *      ),
 *      @OA\Response(
 *         response=404,
 *         description="Product cannot be added"
 *      )
 * )
 */
Flight::route('POST /product', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::productService()->createProduct($data));
});

/**
 * @OA\Put(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Update an existing product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the product",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_name", "price", "image_url", "category_id", "admin_id", "stock"},
 *             @OA\Property(property="product_name", type="string", example="White lilies"),
 *             @OA\Property(property="price", type="number", format="float", example=45.5),
 *             @OA\Property(property="image_url", type="string", example="/frontend/assets/FB69VCP_LOL_preset_proflowers-mx-tile-wide-sv-new.webp"),
 *             @OA\Property(property="category_id", type="integer", example=2),
 *             @OA\Property(property="admin_id", type="integer", example=3),
 *             @OA\Property(property="stock", type="integer", example=15)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product cannot be updated"
 *     )
 * )
 */

Flight::route('PUT /product/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::productService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/product/{id}",
 *     tags={"products"},
 *     summary="Delete a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the product",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product cannot be deleted"
 *     )
 * )
 */
Flight::route('DELETE /product/@id', function($id){
    Flight::json(Flight::productService()->delete($id));
});
?>