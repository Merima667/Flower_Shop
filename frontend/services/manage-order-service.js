var ManageOrderService = {
    getAll: function() {
    const token = localStorage.getItem("user_token");
    $.ajax({
      url: Constants.PROJECT_BASE_URL() + "/order",
      type: "GET",
      beforeSend: function(xhr) {
        xhr.setRequestHeader("Authentication", token);
      },
      success: function(orders) {
        ManageOrderService.renderTable(orders);
      },
      error: function(err) {
        console.error("Error loading orders", err);
      }
    });
  },
  renderTable: function(orders) {
    $("#orders-table").html("");

    orders.forEach(order => {
      const statusDropdown = `
        <select class="form-select form-select-sm" onchange="ManageOrderService.updateStatus(${order.id}, this.value)">
          <option value="pending" ${order.status === "pending" ? "selected" : ""}>Pending</option>
          <option value="shipped" ${order.status === "shipped" ? "selected" : ""}>Shipped</option>
          <option value="delivered" ${order.status === "delivered" ? "selected" : ""}>Delivered</option>
          <option value="cancelled" ${order.status === "cancelled" ? "selected" : ""}>Cancelled</option>
        </select>
      `;

      $("#orders-table").append(`
        <tr>
          <td>${order.id}</td>
          <td>${order.user_name || order.user_id}</td>
          <td>${order.order_date}</td>
          <td>${statusDropdown}</td>
          <td>${order.delivery_address}</td>
          <td>${order.total} KM</td>
        </tr>
      `);
    });
    },
    updateStatus: function(orderId, newStatus) {
        const token = localStorage.getItem("user_token");
        console.log("Updating order:", orderId, "to status:", newStatus);
        $.blockUI({ message: '<h3>Updating...</h3>' });
        $.ajax({
        url: Constants.PROJECT_BASE_URL() + "/order/" + orderId + "/status",
        type: "PUT",
        contentType: "application/json",
        headers: {
            "Authentication": token
        },
        data: JSON.stringify({ status: newStatus }),
        success: function(res) {
          $.unblockUI();
          toastr.success("Order status updated successfully!");
          /*ManageOrderService.getAll();*/
        },
        error: function(err) {
          $.unblockUI();
          console.error("Error updating status", err);
          toastr.error("Failed to update order status.");
        }
        });
    },
    init: function() {
      ManageOrderService.getAll();
    }
}