var ProductService = {
    getById: function(id, callback) {
        console.log("Fetching product with ID:", id);
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/product/" + id,
            type: "GET",
            success: function(product) {
                console.log("Product fetched successfully:", product);
                if(callback) callback(product);
            },
            error: function(e) {
                console.error("Error loading product", e);
            }
        });
    },
     
    renderProduct: function(product) {
        console.log("Product object:", product);
        console.log("Product image URL:", product.image_url);
        $("#product-image").attr("src", product.image_url);
        $("#product-name").text(product.product_name);
        $("#product-category").text(product.category_id);
        $("#product-price").text(product.price + "KM");
        $("#product-description").text(product.description);
        $("#product_id").val(product.id);
        if(product.stock > 0){
            $("#product-stock").text(`In stock: ${product.stock}`);
        } else {
            $("#product-stock").text("Out of stock");
            const outOfStockModal = new bootstrap.Modal(document.getElementById('outOfStockModal'));
            outOfStockModal.show();
        }
        console.log("Product rendered successfully in DOM");
    }
};