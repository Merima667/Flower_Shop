var ManageCategoryService = {
    categories: [],

    getAll: function(callback) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/category",
            type: "GET",
            success: function(categories) {
                console.log("Fetched categories:", categories);
                ManageCategoryService.categories = categories;
                if(callback) callback(categories);
                ManageCategoryService.updateProductDropDowns();
            },
            error: function(err) {
                console.error("Error loading categories", err);
            }
        });
    },
    renderTable: function(categories) {
        const tbody = $("#categories-table");
        if(!tbody.length) return console.error("Categories table body not found");
        tbody.html("");
        categories.forEach(c => {
            tbody.append(`
                <tr>
                    <td>${c.id}</td>
                    <td>${c.category_name || ''}</td>
                    <td>${c.description || ''}</td>
                    <td>
                        <button class="btn btn-sm btn warning" onclick="ManageCategoryService.openEditModal(${c.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="ManageCategoryService.deleteCategory(${c.id})">Delete</button>
                    </td>
                </tr>    
            `);
        });
    },
    openAddModal: function() {
        $("#new-category-name").val("");
        $("#new-category-description").val("");
        const addModal = new bootstrap.Modal(document.getElementById("addCategoryModal"));
        addModal.show();
    },
    addCategory: function() {
        const name = $("#new-category-name").val().trim();
        const description = $("#new-category-description").val().trim()
        if(!name) return alert("Category name is required");

        RestClient.post("/category", {category_name: name, description: description}, function(res) {
            alert("Category added!");
            $("#addCategoryModal").modal("hide");
            ManageCategoryService.getAll(ManageCategoryService.renderTable);
        }, function(err) {
            console.error("Error adding category", err);
            alert("Failed to add category.");
        });
    },
    openEditModal: function(id) {
        const category = ManageCategoryService.categories.find(c => c.id == id);
        if(!category) return alert("Category not found");
        $("#edit-category-id").val(category.id);
        $("#edit-category-name").val(category.category_name);
        $("#edit-category-description").val(category.description);

        const editModal = new bootstrap.Modal(document.getElementById("editCategoryModal"));
        editModal.show();
    },
    updateCategory: function() {
        const id = $("#edit-category-id").val();
        const name = $("#edit-category-name").val().trim();
        const description = $("#edit-category-description").val().trim();
        if(!name) return alert("Category name is required");

        RestClient.put("/category/" + id, {category_name: name, description: description}, function(res) {
            alert("Category updated!");
            $("#editCategoryModal").modal("hide");
            ManageCategoryService.getAll(ManageCategoryService.renderTable);
            }, 
            function(err) {
                console.error("Error updating category", err);
                alert("Update failed.");
        });
    },
    deleteCategory: function(id) {
        if(!confirm("Are you sure you want to delete this category?")) return;

        RestClient.delete("/category/" + id, {}, function(res) {
            alert("Category deleted!");
            ManageCategoryService.getAll(ManageCategoryService.renderTable);
        }, 
        function(err) {
            console.error("Error deleting category", err);
            alert("Failed to delete category.");
        });
    },
    updateProductDropDowns: function() {
        const addSelect = $("#addProductForm [name='category']");
        const editSelect = $("#editProductForm [name='category']");

        addSelect.html('<option value="">Select category</option>');
        editSelect.html('<option value="">Select category</option>');

        ManageCategoryService.categories.forEach(c => {
            addSelect.append(`<option value="${c.id}">${c.category_name}</option>`);
            editSelect.append(`<option value="${c.id}">${c.category_name}</option>`);
        });
    }

}