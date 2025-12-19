let OrderService = {
    init: function(product_id) {
        $("#orderForm").validate({
            rules: {
                address: {
                    required: true,
                    minlength: 5
                },
                quantity: {
                    required: true,
                    number: true, 
                    min: 1
                }
            },
            messages: {
                address: {
                    required: "Please enter your delivery address",
                    minlength: "Address must be at least 5 characters long"
                },
                quantity: {
                    required: "Please enter quantity",
                    number: "Quantity must be a number",
                    min: "Quantity must be at least 1"
                }
            },
            submitHandler: function(form) {
                const quantity = parseInt($("#quantity").val());
                const address = $("#address").val().trim();
                const token = localStorage.getItem("user_token");
                if(!token) return alert("You must be logged in to place an order!");
                const userPayload = JSON.parse(atob(token.split('.')[1]));
                const user_id = userPayload.user.id;

                $.blockUI({ message: '<h3>Placing order...</h3>' });
                $.ajax({
                    url: Constants.PROJECT_BASE_URL + "/product/stock/" + product_id,
                    type: "GET",
                    headers: {
                        "Authentication": token
                    },
                    success: function(stock) {
                        stock = parseInt(stock);
                        if(quantity>stock) {
                            $.unblockUI();
                            $("#stockModalBody").text(`Requested quantity exceeds available stock. Available: ${stock}`);
                            $("#stockModal").modal("show");
                        } else {
                            $.ajax({
                                url: Constants.PROJECT_BASE_URL + "/public/product/" + product_id,
                                type: "GET",
                                success: function(product) {
                                    const payload = {
                                        user_id: user_id,
                                        delivery_address: address,
                                        product_id: product_id,
                                        quantity: quantity,
                                        price: parseFloat(product.price)
                                    };

                                    $.ajax({
                                        url: Constants.PROJECT_BASE_URL + "/order",
                                        type: "POST",
                                        contentType: "application/json",
                                        headers: {
                                            "Authentication": token
                                        },
                                        data: JSON.stringify(payload),
                                        success: function(res) {
                                            $.unblockUI();
                                            toastr.success("Order placed successfully!");
                                            $("#orderForm")[0].reset();
                                        },
                                        error: function(err) {
                                            $.unblockUI();
                                            console.error("Error placing order", err);
                                            toastr.error("Failed to place order. You have to be logged in as a customer.");
                                        }
                                    });
                                },
                                    error: function(err) {
                                        $.unblockUI();
                                        console.error("Error fetching product details", err);
                                        toastr.error("Failed to fetch product info.");
                                    }
                                });
                                
                            }
                        },
                        error: function(err) {
                            $.unblockUI();
                            console.error("Error checking stock", err);
                            toastr.error("Failed to check stock. Check console for details.");
                        }
                  
                    });
                }        
        });
    }
};