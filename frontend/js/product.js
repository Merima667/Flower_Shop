document.getElementById("orderForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const address = document.getElementById("address").value;
  const quantity = document.getElementById("quantity").value;

  if (!address.trim()) {
    alert("Please enter a valid delivery address.");
    return;
  }

  alert(`Order placed successfully!\n\nAddress: ${address}\nQuantity: ${quantity}`);
  this.reset();
});

document.getElementById("reviewForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const review = document.getElementById("review").value.trim();
  if (!review) return;

  const reviewCard = document.createElement("div");
  reviewCard.className = "card mb-3 shadow-sm p-3";
  reviewCard.innerHTML = `<h5>You</h5><p class="text-muted">${review}</p>`;

  document.querySelector(".reviews-section").insertBefore(reviewCard, this);
  this.reset();
});
