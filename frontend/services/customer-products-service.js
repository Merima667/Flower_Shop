var CustomerProducts = {
    getAllProducts: function() {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/product",
            type: "GET",
            success: function(response) {
                let products = response;
                $("#shop-products").html("");
                products.forEach(p => {
                    $("#shop-products").append(`
                        <div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="${p.image_url}" alt="${p.product_name}"/>
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">${p.product_name}</h5>
                                        ${p.price}KM
                                    </div>   
                                </div> 
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="text-center">
                                        <a href="#product" class="btn btn-outline-dark mt-auto view-product" data-id="${p.id}">View more</a>
                                    </div>
                                </div>   
                            </div> 
                        </div>          
                    `);
                });
                console.log("Products loaded successfully:", products);
            },
            error: function(e) {
                console.error("Error loading process", e);
            }
        });
    }
}