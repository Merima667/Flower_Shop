var ProductService = {
    getProductById: function() {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/product/{id}",
            type: "GET",
            success: function(response) {
                let product = response;
                $("#product-image").attr("src", product.image_url);
                $("#product-name").text(product.product_name);
                $("#product-category").text(product.category_id);
                $("#product-price").text(product.price + "KM");
                $("#product-description").attr("src", product.description);
                
                console.log("Products loaded successfully:", products);
            },
            error: function(e) {
                console.error("Error loading process", e);
            }
        });
    }
}