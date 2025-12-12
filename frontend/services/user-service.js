var UserService = {
    init: function() {
        var token = localStorage.getItem("user_token");
        if(token && token !== undefined) {
            window.location.replace("#home");
        }
        $("#loginForm").validate({
            submitHandler: function(form) {
                var entity = Object.fromEntries(new FormData(form).entries());
                console.log("Sending login data:", entity);
                UserService.login(entity);
            },
        });
    },
    login: function (entity) {
        $.ajax({
            url: Constants.PROJECT_BASE_URL + "auth/login",
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log(result);
                localStorage.setItem("user_token", result.data.token);
                UserService.generateMenuItems();
                window.location.replace("#home");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Server error response:", XMLHttpRequest.responseText);
                toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
            },
        });
    },
    
    register: function(entity) {
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault(); 
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if(password !== confirmPassword) {
            alert("Passwords do not match");
            return;
        }

        const formData = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            password: password,
            role: document.getElementById('role').value
        };

    

        $.ajax({
            url: Constants.PROJECT_BASE_URL + "auth/register",
            type: "POST",
            data: JSON.stringify(formData),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log(result);
                localStorage.setItem("user_token", result.data.token);
                window.location.replace("#home");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
            },
        });
        });
    },
    logout: function () {
        localStorage.clear();
        UserService.generateMenuItems();
        window.location.replace("#login");
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