var app = $.spapp({
    defaultView: "#home",
    templateDir: "frontend/views/"
});

app.route({view: 'home'});

app.route({
    view: 'product',
    onReady: function() {
        const productId = localStorage.getItem("selected_product_id");
        if(!productId) return;

        ProductService.getById(productId, ProductService.renderProduct);
        ReviewService.getByProductId(productId, ReviewService.renderReviews);

        const token = localStorage.getItem("user_token");
        let user = null;

        if(token) {
            try {
                const parsed = JSON.parse(atob(token.split('.')[1]));
                user = parsed.user || null;
            } catch(e) {
                user = null;
            }
        }

        if(user) {
            console.log("User exist");
            ReviewService.init(productId);
            OrderService.init(productId);
            $("#reviewForm").show();
            $("#orderForm").show();
        }
        else {
            $("#reviewForm").hide();
            $("#orderForm").hide();
            $("#reviews-container").before('<p class="text-muted">Only logged in users can add reviews and place orders.</p>');
        }
        
    }
});

app.route({
    view: 'login',
    onReady: function() {
        $("#email").focus();
        UserService.init();
        const pwd = document.getElementById("password");
        const toggle = document.getElementById("togglePassword");
        if (toggle && pwd) {
            toggle.addEventListener("click", function () {
                const isPassword = pwd.type === "password";
                pwd.type = isPassword ? "text" : "password";
                toggle.textContent = isPassword ? "Hide" : "Show";
                toggle.setAttribute("aria-pressed", isPassword ? "true" : "false");
            });
        }
    }
});

app.route({
    view: 'register',
    onReady: function() {
        $("#first-name").focus();
        UserService.init();
        const pwd = document.getElementById("password");
        const confirmPwd = document.getElementById("confirmPassword");
        const togglePwd = document.getElementById("togglePassword");
        const toggleConfirmPwd = document.getElementById("toggleConfirmPassword");

        if (togglePwd && pwd) {
            togglePwd.addEventListener("click", function () {
                const isPassword = pwd.type === "password";
                pwd.type = isPassword ? "text" : "password";
                togglePwd.textContent = isPassword ? "Hide" : "Show";
            });
        }

        if (toggleConfirmPwd && confirmPwd) {
            toggleConfirmPwd.addEventListener("click", function () {
                const isPassword = confirmPwd.type === "password";
                confirmPwd.type = isPassword ? "text" : "password";
                toggleConfirmPwd.textContent = isPassword ? "Hide" : "Show";
            });
        }
    }
});

app.route({
    view: 'cartPage'
});

app.run();


function getCurrentView() {
    let hash = window.location.hash || "#home";
    return hash.split("?")[0]; 
}

$(window).on("hashchange", function () {
    const current = getCurrentView();
    console.log("Hash changed, showing:", current);

    $("#spapp section.active").fadeOut(300, function () {
        $("#spapp section").removeClass("active");
        $(current).fadeIn(100).addClass("active");
    });
});

$(document).ready(function () {
    const current = getCurrentView();
    console.log("Initial view:", current);

    $("#spapp section").hide();
    $(current).show().addClass("active");
    UserService.generateMenuItems();
});

$(document).on("click", ".view-product", function(e) {
    e.preventDefault();
    const productId = $(this).data("id");
    localStorage.setItem("selected_product_id", productId);
    window.location.hash = "#product"; 
});
