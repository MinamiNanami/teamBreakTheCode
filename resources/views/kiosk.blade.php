<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JARIEL'S PEAK KIOSK</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FontAwesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Your CSS -->
    <link rel="stylesheet" href="{{ asset('css/kiosk.css') }}" />

    <style>
        .logout-btn {
            background: none;
            border: none;
            color: #2E7D32;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .logout-btn:hover {
            color: #1B5E20;
        }
    </style>
</head>

<body>
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-leaf"></i>
                <h1>JARIEL'S PEAK</h1>
            </div>
            <div class="header-buttons">
                <button class="refresh-btn" id="refresh-menu-btn" title="Refresh Menu">
                    <i class="fas fa-sync-alt"></i>
                </button>

                <button class="cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                    Cart <span class="cart-count">0</span>
                </button>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Log Out">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="main-content">
        <section class="menu-section">
            <div class="menu-categories">
                <button class="category-btn active" data-category="all">All</button>
                <button class="category-btn" data-category="main">Main Course</button>
                <button class="category-btn" data-category="silog">Silog/Exotic Dish</button>
                <button class="category-btn" data-category="pancit">Pancit</button>
                <button class="category-btn" data-category="rice">Rice</button>
                <button class="category-btn" data-category="veggies">Vegetables</button>
                <button class="category-btn" data-category="beverages">Beverages</button>
            </div>

            <div class="menu-items" id="menu-items">
                @foreach($products as $product)
                    <div class="menu-item" data-category="{{ strtolower($product->category) }}">
                        <h4>{{ $product->name }}</h4>
                        <p>₱{{ number_format($product->price, 2) }}</p>
                        <button class="add-to-cart"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}">
                            Add
                        </button>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="order-panel">
            <section class="order-section">
                <h2>Your Order</h2>

                <div class="order-method">
                    <h3>Order Method</h3>
                    <div class="method-options">
                        <button class="method-btn active" data-method="dine-in">Dine In</button>
                        <button class="method-btn" data-method="take-out">Take Out</button>
                    </div>
                </div>

                <div class="payment-method">
                    <h3>Payment Method</h3>
                    <div class="payment-options">
                        <div class="payment-option active" data-payment="cash">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Cash</span>
                        </div>
                        <div class="payment-option" data-payment="token">
                            <i class="fas fa-coins"></i>
                            <span>Token</span>
                        </div>
                    </div>
                </div>

                <div class="cart-items">
                    <p class="empty-cart-message">Your cart is empty</p>
                </div>

                <div class="cart-total">
                    <span>Total:</span>
                    <span class="total-amount">₱0.00</span>
                </div>

                <button class="checkout-btn" disabled>Checkout</button>
            </section>
        </div>
    </div>
</div>

<!-- View Order Modal -->
<div id="checkout-modal" class="modal hidden" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Complete Your Order</h2>
            <button class="close-btn" id="close-checkout-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="checkout-form" method="POST" action="{{ route('orders.store') }}">
                @csrf
                <div class="form-group">
                    <label for="customer-name">Customer Name</label>
                    <input type="text" id="customer-name" name="customer_name"
                           placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="table-number">Table Number</label>
                    <select id="table-number" name="table_number" required>
                        <option value="">Select Table</option>
                        <option value="Table 1">Table 1</option>
                        <option value="Table 2">Table 2</option>
                        <option value="Table 3">Table 3</option>
                        <option value="Table 4">Table 4</option>
                        <option value="Table 5">Table 5</option>
                        <option value="Counter">Counter</option>
                        <option value="Take Out">Take Out</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="order-method">Order Method</label>
                    <select id="order-method" name="order_method" required>
                        <option value="dine-in">Dine In</option>
                        <option value="take-out">Take Out</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment-method">Payment Method</label>
                    <select id="payment-method" name="payment_method" required>
                        <option value="cash">Cash</option>
                        <option value="token">Token</option>
                    </select>
                </div>

                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div id="checkout-items"></div>
                    <div class="total">
                        <strong>Total: ₱<span id="checkout-total">0.00</span></strong>
                    </div>
                </div>

                <!-- Hidden input to pass cart data -->
                <input type="hidden" name="cart" id="cart-data">

                <button type="submit" class="checkout-submit-btn">Place Order</button>
            </form>
        </div>
    </div>
</div>

<!-- Cart JS -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartCount = document.querySelector(".cart-count");
    const totalAmountEl = document.querySelector(".total-amount");
    const checkoutBtn = document.querySelector(".checkout-btn");
    const checkoutItemsEl = document.getElementById("checkout-items");
    const checkoutTotalEl = document.getElementById("checkout-total");
    const checkoutModal = document.getElementById("checkout-modal");
    const closeCheckoutModal = document.getElementById("close-checkout-modal");
    const cartDataInput = document.getElementById("cart-data");

    let cart = [];

    // Add product to cart
    document.body.addEventListener("click", e => {
        if (e.target.classList.contains("add-to-cart")) {
            const id = e.target.dataset.id;
            const name = e.target.dataset.name;
            const price = parseFloat(e.target.dataset.price);

            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            updateCart();
        }
    });

    // Update cart
    function updateCart() {
        cartItemsContainer.innerHTML = "";
        let total = 0, count = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = "<p class='empty-cart-message'>Your cart is empty</p>";
            checkoutBtn.disabled = true;
        } else {
            cart.forEach(item => {
                total += item.price * item.qty;
                count += item.qty;

                const div = document.createElement("div");
                div.classList.add("cart-item");
                div.innerHTML = `
                    <span>${item.name} x ${item.qty}</span>
                    <span>₱${(item.price * item.qty).toFixed(2)}</span>
                    <button class="remove-item" data-id="${item.id}">Remove</button>
                `;
                cartItemsContainer.appendChild(div);
            });
            checkoutBtn.disabled = false;
        }

        cartCount.textContent = count;
        totalAmountEl.textContent = `₱${total.toFixed(2)}`;
        checkoutTotalEl.textContent = total.toFixed(2);

        // Update checkout modal items
        checkoutItemsEl.innerHTML = cart.map(i =>
            `<p>${i.name} x ${i.qty} — ₱${(i.price * i.qty).toFixed(2)}</p>`
        ).join("");

        // Save cart JSON for backend
        cartDataInput.value = JSON.stringify(cart);
    }

    // Remove item
    document.body.addEventListener("click", e => {
        if (e.target.classList.contains("remove-item")) {
            const id = e.target.dataset.id;
            cart = cart.filter(item => item.id !== id);
            updateCart();
        }
    });

    // Open checkout modal
    checkoutBtn.addEventListener("click", () => {
        checkoutModal.style.display = "block";
    });

    // Close modal
    closeCheckoutModal.addEventListener("click", () => {
        checkoutModal.style.display = "none";
    });
});
</script>
</body>
</html>
