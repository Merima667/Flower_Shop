var app = $.spapp({
    defaultView: "#home",
    templateDir: "frontend/views/"
});

app.route({view: 'home'});

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
                alert("Login successful!");
                window.location.hash = "#home"; 
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
            const name = document.getElementById("name");
            const email = document.getElementById("email");
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("confirmPassword");
            let isValid = true;
            if (name.value.trim().length < 3) {
                name.classList.add("is-invalid");
                isValid = false;
            } else {
                name.classList.remove("is-invalid");
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
                alert("Registration successful!");
                window.location.hash = "#login";
            }
        });
    }
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
