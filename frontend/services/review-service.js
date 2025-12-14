var ReviewService = {
    getByProductId: function(id, callback) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/public/review/product/" + id,
            type: "GET", 
            success: function(reviews) {
                if(callback) callback(reviews);
            },
            error: function(e) {
                console.error("Error loading reviews", e);
            }
        });
    },

    addReview: function(product_id, review_description, callback) {
        const token = localStorage.getItem("user_token");
        const userPayload = token ? JSON.parse(atob(token.split('.')[1])) : {};
        const user_id = userPayload.user ? userPayload.user.id : null;
        const name = userPayload.user ? userPayload.user.first_name : "Anonymous";

        const payload = {
            product_id: product_id,
            review_description: review_description,
            user_id: user_id,
            name: name
        }
        console.log("DEBUG: Sending review payload", payload);

        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/review",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(payload),
            headers: {"Authentication": token},
            success: function(response) {
                console.log("DEBUG: Review response", response);
                if(callback) callback(response);
            },
            error: function(err) {
                console.error("Error placing order", err);
                alert("Failed to add review. You have to be logged in as a customer.");
            }
        });
    },

    renderReviews: function(reviews) {
        $("#reviews-container").html("");
        reviews.forEach(r => {
            $("#reviews-container").append(`
                <div class="card mb-3 shadow-sm p-3">
                    <p class="text-muted">${r.review_description}</p>
                </div>    
            `);
        });
    },

    init: function(product_id) {
        $("#reviewForm").off("submit").on("submit", function(e) {
            e.preventDefault();
            const reviewText = $("#review").val().trim();
            if(!reviewText) return;

            ReviewService.addReview(product_id, reviewText, function(newReview) {
                console.log("DEBUG: Review response", newReview);
                $("#reviews-container").prepend(`
                    <div class="card mb-3 shadow-sm p-3">
                        <p class="text-muted">${newReview.review_description}</p>
                    </div> 
                `);
                $("#reviewForm")[0].reset();
            });
        });
    }
};