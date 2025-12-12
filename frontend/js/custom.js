var app = $.spapp({
    defaultView: "#home",
    templateDir: "frontend/views/"
});

app.route({view: 'home'});

app.route({
    view: 'product',
    onReady: function() {
        const params = new URLSearchParams(window.location.hash.split('?')[1]);
        const productId = params.get('id');
        if(productId) {
            ProductService.getById(productId, function(product) {
                $("#product-image").attr("src", product.image);
                $("#product-name").text(product.product_name);
                $("#product-category").text(product.category);
                $("#product-price").attr(product.price + "KM");
                $("#product-description").attr(product.description);
            });
        }
        $("#orderForm").on("submit", function(e) {
            e.preventDefault();

            const address = $("#address").val();
            const quantity =$("#quantity").val();

            if (!address.trim()) {
                alert("Please enter a valid delivery address.");
                return;
            }

            alert(`Order placed successfully!\n\nAddress: ${address}\nQuantity: ${quantity}`);
            this.reset();
        });
        $("#reviewForm").on("submit", function(e) {
            e.preventDefault();
            const review = $("#review").val().trim();
            if (!review) return;

            const reviewCard = `<div class="card mb-3 shadow-sm p-3">
                                    <h5>You</h5>
                                    <p class="text-muted">${review}</p>
                                </div>`;
            $("#reviews-container").append(reviewCard);
            this.reset();
        });
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

$(window).on("hashchange", function () {
    var current = window.location.hash || "#home";

    $("#spapp section.active").fadeOut(300, function () {
        $("#spapp section").removeClass("active");
        $(current).fadeIn(100).addClass("active");
    });
});

$(document).ready(function () {
    var current = window.location.hash || "#home";
    $("#spapp section").hide();
    $(current).show().addClass("active");    
});
