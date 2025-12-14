var CustomerOrderService = {
    getMyOrders: function () {
        const token = localStorage.getItem("user_token");
        function parseJwt(token) {
            try {
                return JSON.parse(atob(token.split('.')[1]));
            } catch (e) {
                return null;
            }
        }
        const payload = parseJwt(token);
        const userId = payload?.user?.id;
        if (!userId) {
            console.error("User ID not found in token");
            return;
        }

        $.ajax({
            url: Constants.PROJECT_BASE_URL + "/order/user/" + userId,
            type: "GET",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authentication", token);
            },
            success: function (response) {
                console.log(response);
                CustomerOrderService.renderOrders(response);
            },
            error: function (err) {
                console.error("Error loading orders", err);
            }
        });
    },
    renderOrders: function (orders) {
        $("#ordersTableBody").html("");

        if (!Array.isArray(orders) || orders.length === 0) {
            $("#ordersTableBody").append(`
                <tr>
                <td colspan="5" class="text-center text-muted">
                    You have no orders yet.
                </td>
                </tr>
            `);
            return;
        }
        orders.forEach((order, index) => {
        $("#ordersTableBody").append(`
            <tr>
            <td>${index + 1}</td>
            <td>${order.order_date}</td>
            <td>
                <span class="badge bg-${CustomerOrderService.getStatusColor(order.status)}">
                ${order.status}
                </span>
            </td>
            <td>${order.delivery_address}</td>
            <td><strong>${order.total} KM</strong></td>
            </tr>
        `);
        });
    },
    getStatusColor: function (status) {
    switch (status) {
      case "pending": return "warning";
      case "shipped": return "info";
      case "delivered": return "success";
      case "cancelled": return "danger";
      default: return "secondary";
    }
  },
}

     