
const cartBtn = document.getElementById("cartBtn");
const orderPanel = document.getElementById("orderPanel");
const cartCount = document.getElementById("cartCount");
const cartItems = document.getElementById("cartItems");
const cartTotal = document.getElementById("cartTotal");
const checkoutBtn = document.getElementById("checkoutBtn");
const checkoutModal = document.getElementById("checkoutModal");
const closeModal = document.getElementById("closeModal");
const confirmCheckout = document.getElementById("confirmCheckout");

let cart = [];
let total = 0;

// Toggle Cart Panel
cartBtn.addEventListener("click", () => {
    orderPanel.classList.toggle("show");
});

// Add to Cart
document.querySelectorAll(".add-to-cart").forEach(button => {
    button.addEventListener("click", () => {
        const name = button.getAttribute("data-name");
        const price = parseInt(button.getAttribute("data-price"));

        cart.push({ name, price });
        total += price;

        renderCart();
    });
});

// Render Cart
function renderCart() {
    cartItems.innerHTML = "";
    cart.forEach((item, index) => {
        const li = document.createElement("li");
        li.textContent = `${item.name} - ₱${item.price}`;

        // Remove button
        const removeBtn = document.createElement("button");
        removeBtn.textContent = "x";
        removeBtn.style.marginLeft = "10px";
        removeBtn.style.background = "red";
        removeBtn.style.color = "white";
        removeBtn.style.border = "none";
        removeBtn.style.borderRadius = "4px";
        removeBtn.style.cursor = "pointer";
        removeBtn.onclick = () => removeItem(index);

        li.appendChild(removeBtn);
        cartItems.appendChild(li);
    });

    cartCount.textContent = cart.length;
    cartTotal.textContent = total;
}

// Remove Item
function removeItem(index) {
    total -= cart[index].price;
    cart.splice(index, 1);
    renderCart();
}

// Checkout
checkoutBtn.addEventListener("click", () => {
    checkoutModal.classList.add("show");
});

closeModal.addEventListener("click", () => {
    checkoutModal.classList.remove("show");
});

confirmCheckout.addEventListener("click", () => {
    cart = [];
    total = 0;
    renderCart();
    checkoutModal.classList.remove("show");
    alert("Order confirmed!");
});
