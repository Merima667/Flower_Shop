const CartPage = {
    cart: [],

    show() {
        $("section").not("#cartPage").hide();
        $("#cartPage").show();
        this.render();
    },

    addItem(product) {
        this.cart.push(product);
        this.render();
    },

    render() {
        const itemsDiv = $("#cartItems");
        itemsDiv.html("");

        if (this.cart.length === 0) {
            itemsDiv.html(`<p class="text-center text-muted">Your cart is empty.</p>`);
            $("#cartTotal").text("$0.00");
            return;
        }

        let total = 0;

        this.cart.forEach((item, index) => {
            itemsDiv.append(`
                <div class="cart-item">
                    <span class="cart-item-name">${item.name}</span>
                    <span class="cart-item-price">$${item.price.toFixed(2)}</span>
                    <button class="btn btn-sm btn-outline-danger remove-btn" data-index="${index}">Remove</button>
                </div>
            `);
            total += item.price;
        });

        $("#cartTotal").text(`$${total.toFixed(2)}`);

        $(".remove-btn").click((e) => {
            const index = $(e.target).data("index");
            this.cart.splice(index, 1);
            this.render();
        });
    }
};

// checkout dugme
$(document).on("click", "#checkoutBtn", function() {
    if (CartPage.cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    // ovdje ide eventualna AJAX logika ka backendu
    console.log("Order:", CartPage.cart);
    alert("Order placed successfully!");
    CartPage.cart = [];
    CartPage.render();
});
