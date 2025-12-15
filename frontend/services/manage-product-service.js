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

        RestClient.post("/product", payload, function(res) {
            alert("Product added!");
            $("#addProductModal").modal("hide");
            ManageProductService.getAll(ManageProductService.renderTable);
        }, function(err) {
            console.error("Error adding product", err);
            alert("Failed to add product. You have to be logged in as an admin.");
        });
    },

    openEditModal: function(id) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/product/" + id,
            type: "GET",
            success: function(p) {
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

        RestClient.put("/product/" + id, payload, function(res) {
            alert("Product updated!");
            $("#editProductModal").modal("hide");
            ManageProductService.getAll(ManageProductService.renderTable);
            }, 
            function(err) {
                console.error("Error updating product", err);
                alert("Update failed. Check console.");
            }
        );
    },

    deleteProduct: function(id) {
        if(!confirm("Are you sure you want to delete this product?")) return;

        RestClient.delete("/product/" + id, {}, function(res) {
            alert("Product deleted!");
            ManageProductService.getAll(ManageProductService.renderTable);
        }, 
        function(err) {
            console.error("Error deleting product", err);
        });
    }
}