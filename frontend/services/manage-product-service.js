var ManageProductService = {
    getAll: function(callback) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/product",
            type: "GET",
            success: function(products) {
                if(callback) callback(products);
            },
            error: function(err) {
                console.error("Error loading products", err);
            }
        });
    },
    renderTable: function(products) {
        const tbody = $("#products-table");
        if(!tbody.length) return console.error("Table body not found");
        tbody.html("");
        products.forEach(p => {
            tbody.append(`
                <tr> 
                    <td>
                        <img src="${p.image_url}" class="img-thumbnail" style="width:60px; height:60px; object-fit:cover;">
                    </td>       
                    <td>${p.product_name}</td>  
                    <td>${p.category_id}</td> 
                    <td>${p.price} KM</td> 
                    <td>
                        <span class="badge ${p.stock>0 ? 'bg-success' : 'bg-danger'}">${p.stock}</span>
                    </td> 
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="ManageProductService.openEditModal(${p.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="ManageProductService.deleteProduct(${p.id})">Delete</button>
                    </td>
                </tr>    
            `)
        });
    },
    openAddModal: function() {
        const addModal = new bootstrap.Modal(document.getElementById("addProductModal"));
        addModal.show();
    },
    addProduct: function() {
        const currentUserRaw = localStorage.getItem("currentUser");
        if(!currentUserRaw) {
            alert("You must be logged in as admin to add a product");
            return;
        }
        const currentUser = JSON.parse(currentUserRaw);

        const category_id = parseInt(
            $("#addProductForm [name='category']").val()
        );

        if (!category_id) {
            alert("Invalid category selected");
            return;
        }

        const payload = {
            product_name: $("#addProductForm [name='name']").val(),
            category_id: category_id,
            price: parseFloat($("#addProductForm [name='price']").val()),
            stock: parseInt($("#addProductForm [name='stock']").val()),
            description: $("#addProductForm [name='description']").val(),
            image_url: $("#addProductForm [name='image']").val(),
            user_id: currentUser.id
        };
        console.log("Payload for add:", payload);

        $.blockUI({ message: '<h3>Saving...</h3>' });
        RestClient.post("/product", payload, function(res) {
            $.unblockUI();
            toastr.success("Product added!");
            $("#addProductModal").modal("hide");
            ManageProductService.getAll(ManageProductService.renderTable);
        }, function(err) {
            $.unblockUI();
            console.error("Error adding product", err);
            toastr.error("Failed to add product. You have to be logged in as an admin.");
        });
    },

    openEditModal: function(id) {
        $.blockUI({ message: '<h3>Loading...</h3>' });
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/product/" + id,
            type: "GET",
            success: function(p) {
                $.unblockUI();
                $("#edit-product-id").val(p.id);
                $("#edit-name").val(p.product_name);
                $("#category").val(p.category_id);
                $("#edit-price").val(p.price);
                $("#edit-description").val(p.description);
                $("#edit-image").val(p.image_url);

                const editModal = new bootstrap.Modal(document.getElementById("editProductModal"));
                editModal.show();
            },
            error: function(e) {
                $.unblockUI();
                console.error("Error fetching product",e);
            }
        });
    },

    updateProduct: function() {
        const id = $("#edit-product-id").val();
        if(!id) {
            alert("Product ID is missing");
            return;
        }
        const category_id = parseInt(
            $("#editProductForm [name='category']").val()
        );

        if (!category_id) {
            alert("Invalid category selected");
            return;
        }

        const currentUserRaw = localStorage.getItem("currentUser");
        if(!currentUserRaw) {
            alert("You must be logged in as admin");
            return;
        }

        const currentUser = JSON.parse(currentUserRaw);

        const payload = {
            product_name: $("#edit-name").val(),
            category_id: category_id,
            price: parseFloat($("#edit-price").val()),
            stock: parseInt($("#edit-stock").val()),
            description: $("#edit-description").val(),
            image_url: $("#edit-image").val(),
            user_id: currentUser.id
        };

        console.log("Payload for update:", payload);

        $.blockUI({ message: '<h3>Updating...</h3>' });
        RestClient.put("/product/" + id, payload, function(res) {
            $.unblockUI();
            toastr.success("Product updated!");
            $("#editProductModal").modal("hide");
            ManageProductService.getAll(ManageProductService.renderTable);
            }, 
            function(err) {
                $.unblockUI();
                console.error("Error updating product", err);
                toastr.error("Update failed. Check console.");
            }
        );
    },

    deleteProduct: function(id) {
        if(!confirm("Are you sure you want to delete this product?")) return;

        $.blockUI({ message: '<h3>Deleting...</h3>' });
        RestClient.delete("/product/" + id, {}, function(res) {
            $.unblockUI();
            toastr.success("Product deleted!");
            ManageProductService.getAll(ManageProductService.renderTable);
        }, 
        function(err) {
            $.unblockUI();
            console.error("Error deleting product", err);
        });
    },

    init: function() {
        $("#addProductForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                }, 
                category: {
                    required: true
                },
                price: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                stock: {
                    required: true,
                    number: true,
                    min: 0
                },
                description: {
                    required: true,
                    min: 5
                },
                image: {
                    url: true
                }
            },
            messages: {
                name: "Please enter a name of the product(minimum 2 characters)",
                category: "Please select a category",
                price: {
                    required: "Please enter a price",
                    number: "Price must be a number",
                    min: "Price must be at least 0.01"
                },
                stock: {
                    required: "Please enter stock quantity",
                    number: "Stock must be a number",
                    min: "Stock cannot be negative"
                },
                description: "Please enter a valid description(minimum 5 characters)"
            },
            submitHandler: function(form) {
                ManageProductService.addProduct();
            },
        });
        $("#editProductForm").validate({
            rules: {
                edit_name: {
                    required: true,
                    minlength: 2
                }, 
                category: {
                    required: true
                },
                edit_price: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                edit_stock: {
                    required: true,
                    number: true,
                    min: 0
                },
                edit_description: {
                    required: true,
                    min: 5
                },
                edit_image: {
                    url: true
                }
            },
            messages: {
                name: "Please enter a name of the product(minimum 2 characters)",
                category: "Please select a category",
                price: {
                    required: "Please enter a price",
                    number: "Price must be a number",
                    min: "Price must be at least 0.01"
                },
                stock: {
                    required: "Please enter stock quantity",
                    number: "Stock must be a number",
                    min: "Stock cannot be negative"
                },
                description: "Please enter a valid description(minimum 5 characters)"
            },
            submitHandler: function(form) {
                ManageProductService.updateProduct();
            },
        });
        ManageProductService.getAll(ManageProductService.renderTable);
    }
}