let OrderService = {
    init: function(product_id) {
        $("#orderForm").off("submit").on("submit", function(e) {
            e.preventDefault();
            const quantity = parseInt($("#quantity").val());
            const address = $("#address").val().trim();
            if(!address) return alert("Enter your address.");
            const token = localStorage.getItem("user_token");
            if(!token) return alert("You must be logged in to place an order!");
            const userPayload = JSON.parse(atob(token.split('.')[1]));
            const user_id = userPayload.user.id;

            $.ajax({
                url: Constants.PROJECT_BASE_URL + "/product/stock/" + product_id,
                type: "GET",
                headers: {
                    "Authentication": token
                },
                success: function(stock) {
                    stock = parseInt(stock);
                    if(quantity>stock) {
                        $("#stockModalBody").text(`Requested quantity exceeds available stock. Available: ${stock}`);
                        $("#stockModal").modal("show");
                    } else {
                        $.ajax({
                            url: Constants.PROJECT_BASE_URL + "/public/product/" + product_id,
                            type: "GET",
                            success: function(product) {
                                const price = parseFloat(product.price);

                                $.ajax({
                                    url: Constants.PROJECT_BASE_URL + "/order",
                                    type: "POST",
                                    contentType: "application/json",
                                    headers: {
                                        "Authentication": token
                                    },
                                    data: JSON.stringify({
                                        user_id: user_id,
                                        delivery_address: address,
                                        product_id: product_id,
                                        quantity: quantity,
                                        price: price
                                    }),
                                    success: function(res) {
                                        alert("Order placed successfully!");
                                        $("#orderForm")[0].reset();
                                    },
                                    error: function(err) {
                                        console.error("Error placing order", err);
                                        alert("Failed to place order. You have to be logged in as a customer.");
                                    }
                                });
                            },
                            error: function(err) {
                                console.error("Error fetching product details", err);
                                alert("Failed to fetch product info.");
                            }
                        });
                        
                    }
                },
                error: function(err) {
                    console.error("Error checking stock", err);
                    alert("Failed to check stock. Check console for details.");
                }
            });
        });
    }
};