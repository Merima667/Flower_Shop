var UserService = {
    init: function() {
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
            window.location.replace("#home");
            return;
        }
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                email: "Please enter a valid email address",
                password: "Minimum 6 characters"
            },
            submitHandler: function(form) {
                var entity = Object.fromEntries(new FormData(form).entries());
                console.log("Sending login data:", entity);
                UserService.login(entity);
            },
        });
        $("#registerForm").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                }, 
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                role: {
                    required: true
                }
            },
            messages: {
                first_name: "Please enter your first name(minimum 2 characters)",
                last_name: "Please enter your last name(minimum 2 characters)",
                email: "Please enter a valid email address",
                password: "Please enter a valid password(minimum 6 chracters)",
                role: "Please select a role"
            },
            submitHandler: function(form) {
                var entity = Object.fromEntries(new FormData(form).entries());
                console.log("Sending login data:", entity);
                UserService.register(entity);
            },
        });
    },
    login: function (entity) {
        $.blockUI({ message: '<h3>Logging in...</h3>' });
        $.ajax({
            url: Constants.PROJECT_BASE_URL() + "/auth/login",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                $.unblockUI();
                console.log("Login success:",result);
                localStorage.setItem("user_token", result.data.token);

                const parsed = Utils.parseJwt(result.data.token);
                if(parsed && parsed.user) {
                    localStorage.setItem("currentUser", JSON.stringify({
                        id: parsed.user.id,
                        first_name: parsed.user.first_name,
                        last_name: parsed.user.last_name,
                        email: parsed.user.email,
                        role: parsed.user.role
                    }));
                } else {
                    console.warn("JWT parsed, but user object missing");
                }

                UserService.generateMenuItems();
                window.location.replace("#home");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.unblockUI();
                console.log("Server error response:", XMLHttpRequest.responseText);
                toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
            },
        });
    },
    
    register: function(entity) {
        const password = entity.password;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if(password !== confirmPassword) {
            alert("Passwords do not match");
            return;
        }
        delete entity.confirmPassword;
        console.log("Sending register entity:", entity);
    
        $.blockUI({ message: '<h3>Registering...</h3>' });
        $.ajax({
            url: Constants.PROJECT_BASE_URL() + "/auth/register",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                $.unblockUI();
                console.log(result);
                localStorage.setItem("user_token", result.data.token);
                window.location.replace("#home");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.unblockUI();
                toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
            },
        });
    },
    logout: function () {
        localStorage.clear();
        UserService.generateMenuItems();
        window.location.replace("#home");
        const current = "#home";
        $("#spapp section.active").fadeOut(0, function () {
            $("#spapp section").removeClass("active");
            $(current).fadeIn(0).addClass("active");
        });
    },

    generateMenuItems: function(){
        const token = localStorage.getItem("user_token");
        let user = null;
        if(token) {
            try {
                user = Utils.parseJwt(token).user;
            } catch(e) {
                user = null;
            }
        }
        let nav = '';
        if(user && user.role) {
            switch(user.role) {
                case Constants.USER_ROLE:
                    nav += '<li class="nav-item"><a class="nav-link text-dark" href="#shop">Shop</a></li>';
                    nav += '<li class="nav-item"><a class="nav-link text-dark" href="#location">Location</a></li>';
                    nav += '<li class="nav-item"><a class="nav-link text-dark" href="#cartPage">Cart</a></li>';
                    nav += '<li class="nav-item"><a class="logout-link nav-link" href="#" onclick="UserService.logout()">Logout</a></li>';
                    break;
                case Constants.ADMIN_ROLE:
                    nav += '<li class="nav-item"><a class="nav-link text-dark" href="#dashboard">Dashboard</a></li>';
                    nav += '<li class="nav-item"><a class="nav-link text-dark" href="#manage-products">Manage Products</a></li>';
                    nav += '<li class="nav-item"><a class="logout-link nav-link" href="#" onclick="UserService.logout()">Logout</a></li>';
                    break; 
            }
        } else {
            nav += '<li class="nav-item"><a class="nav-link text-dark" href="#home">Home</a></li>';
            nav += '<li class="nav-item"><a class="nav-link text-dark" href="#shop">Shop</a></li>';
            nav += '<li class="nav-item"><a class="nav-link text-dark" href="#location">Location</a></li>';
            nav += '<li class="nav-item"><a class="nav-link text-dark" href="#login">Login</a></li>';
        }
        $("#navbar-items").html(nav);
    }
}