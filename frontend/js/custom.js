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

        if(localStorage.getItem("user_token")) {
            ReviewService.init(productId);
            OrderService.init(productId);
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
        const form = document.getElementById("loginForm");
        if (!form) return;
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
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            let isValid = true;
            if (!email.value.includes("@") || !email.value.includes(".")) {
                email.classList.add("is-invalid");
                isValid = false;
            } else {
                email.classList.remove("is-invalid");
            }
            if (password.value.length < 6) {
                password.classList.add("is-invalid");
                isValid = false;
            } else {
                password.classList.remove("is-invalid");
            }
            if (isValid) {
                UserService.login({email: email.value, password: password.value}); 
            }
        });
    }
});

app.route({
    view: 'register',
    onReady: function() {
        const form = document.getElementById("registerForm");
        if (!form) return;
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
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const first_name = document.getElementById("first_name");
            const last_name = document.getElementById("last_name");
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirmPassword");
            let isValid = true;
            if (first_name.value.trim().length < 3) {
                first_name.classList.add("is-invalid");
                isValid = false;
            } else {
                first_name.classList.remove("is-invalid");
            }
            if (last_name.value.trim().length < 3) {
                last_name.classList.add("is-invalid");
                isValid = false;
            } else {
                last_name.classList.remove("is-invalid");
            }
            if (!email.value.includes("@") || !email.value.includes(".")) {
                email.classList.add("is-invalid");
                isValid = false;
            } else {
                email.classList.remove("is-invalid");
            }
            if (password.value.length < 6) {
                password.classList.add("is-invalid");
                isValid = false;
            } else {
                password.classList.remove("is-invalid");
            }
            if (confirmPassword.value !== password.value || confirmPassword.value === "") {
                confirmPassword.classList.add("is-invalid");
                isValid = false;
            } else {
                confirmPassword.classList.remove("is-invalid");
            }
            if (isValid) {
                UserService.register({
                first_name: first_name.value,
                last_name: last_name.value,
                email: email.value,
                password: password.value
            });
            }
        });
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
});

$(document).on("click", ".view-product", function(e) {
    e.preventDefault();
    const productId = $(this).data("id");
    localStorage.setItem("selected_product_id", productId);
    window.location.hash = "#product"; 
});
