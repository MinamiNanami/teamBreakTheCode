{{-- resources/views/kiosk.blade.php --}}
@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jariel's Peak - Kiosk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/kiosk.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Centralized modal */
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-items-modal .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 6px 0;
        }

        .cart-item button {
            background: none;
            border: none;
            font-size: 16px;
            margin: 0 2px;
            cursor: pointer;
        }

        /* New product button */
        .new-product-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            margin: 30px auto;
            display: block;
        }

        .new-product-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .new-product-btn i {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo"><i class="fas fa-leaf"></i>
                <h1>JARIEL'S PEAK</h1>
            </div>
            <button class="cart-btn"><i class="fas fa-shopping-cart"></i> Cart <span class="cart-count">0</span></button>
        </div>
    </header>

    <div class="main-content">
        <!-- Menu Section -->
        <div class="menu-section">
            <div class="menu-categories">
                <button class="category-btn active" data-category="all">All</button>
                <button class="category-btn" data-category="food">Food</button>
                <button class="category-btn" data-category="drinks">Drinks</button>
                <button class="category-btn" data-category="snacks">Snacks</button>
                <button class="category-btn" data-category="desserts">Desserts</button>
            </div>
            <div class="menu-items">
                @foreach($products as $category => $items)
                @foreach($items as $p)
                @php
                $pName = $p->name ?? 'Item';
                $pDesc = $p->description ?? '';
                $pPrice = $p->price ?? 0;
                $pId = $p->id ?? Str::slug($pName);
                $pImg = !empty($p->image)?asset('storage/'.$p->image):asset('images/no-image.png');
                $catSlug = Str::slug($category);
                @endphp
                <div class="menu-item" data-category="{{ $catSlug }}">
                    <div class="menu-item-img" style="background-image:url('{{ $pImg }}');"></div>
                    <div class="menu-item-info">
                        <div class="menu-item-name">{{ $pName }}</div>
                        <div class="menu-item-desc">{{ $pDesc }}</div>
                        <div class="menu-item-bottom">
                            <span class="menu-item-price">₱{{ number_format((float)$pPrice,2) }}</span>
                            <button class="add-to-cart" data-id="{{ $pId }}" data-name="{{ $pName }}" data-price="{{ (float)$pPrice }}"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <!-- New Product Modal -->
    <div id="newProductModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeNewProductModal()">&times;</span>
            <h2>Add New Product</h2>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Name</label>
                <input type="text" name="name" required>
                <label>Price</label>
                <input type="number" name="price" step="0.01" required>
                <label>Category</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="food">Food</option>
                    <option value="drinks">Drinks</option>
                    <option value="snacks">Snacks</option>
                    <option value="desserts">Desserts</option>
                </select>
                <label>Image</label>
                <input type="file" name="image">
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- Cart Modal -->
    <div id="cartModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeCartModal()">&times;</span>
            <h2>Your Cart</h2>
            <div class="cart-items-modal">
                <p class="empty-cart">No items added yet.</p>
            </div>
            <div class="cart-total-modal" style="display:none;"><span>Total:</span> <span class="total-price-modal">₱0.00</span></div>
            <button class="checkout-btn-modal" disabled>Checkout</button>
        </div>
    </div>

    <!-- Checkout Form Modal -->
    <div id="checkoutModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeCheckoutModal()">&times;</span>
            <h2>Checkout</h2>
            <form id="checkoutForm">
                <label>Customer Name</label>
                <input type="text" name="customer_name" required>

                <label>Order Type</label>
                <select name="order_type" id="orderType" required>
                    <option value="">-- Select Order Type --</option>
                    <option value="dine_in">Dine In</option>
                    <option value="take_out">Take Out</option>
                </select>

                <label id="tableLabel" style="display:none;">Table Number</label>
                <input type="text" name="table_number" id="tableNumber" style="display:none;">

                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                    <option value="card">Card</option>
                </select>

                <button type="submit">Place Order</button>
            </form>
        </div>
    </div>

    <script>
        // Modal functions
        function openNewProductModal(e) {
            e.preventDefault();
            document.getElementById('newProductModal').style.display = 'flex';
        }

        function closeNewProductModal() {
            document.getElementById('newProductModal').style.display = 'none';
        }

        // Cart modal
        const cartBtn = document.querySelector('.cart-btn');
        const cartModal = document.getElementById('cartModal');
        const cartItemsModal = cartModal.querySelector('.cart-items-modal');
        const totalPriceModal = cartModal.querySelector('.total-price-modal');
        const cartTotalModal = cartModal.querySelector('.cart-total-modal');
        const checkoutBtnModal = cartModal.querySelector('.checkout-btn-modal');
        cartBtn.addEventListener('click', () => {
            cartModal.style.display = 'flex';
            updateCartModal();
        });

        function closeCartModal() {
            cartModal.style.display = 'none';
        }

        // Cart logic
        let cart = [];
        const cartCountEl = document.querySelector('.cart-count');

        // Update cart display
        function updateCart() {
            cartCountEl.textContent = cart.reduce((s, i) => s + i.qty, 0);
            updateCartModal();
        }

        // Update modal content
        function updateCartModal() {
            cartItemsModal.innerHTML = '';
            if (cart.length === 0) {
                cartItemsModal.innerHTML = '<p class="empty-cart">No items added yet.</p>';
                cartTotalModal.style.display = 'none';
                checkoutBtnModal.disabled = true;
                return;
            }
            let total = 0;
            cart.forEach((item, index) => {
                total += item.price * item.qty;
                const div = document.createElement('div');
                div.classList.add('cart-item');
                div.innerHTML = `
                    <span>${item.name}</span>
                    <span>
                        <button onclick="changeQty(${index},-1)">-</button>
                        ${item.qty}
                        <button onclick="changeQty(${index},1)">+</button>
                        <button onclick="removeItem(${index})"><i class="fas fa-trash"></i></button>
                    </span>
                    <span>₱${(item.price*item.qty).toFixed(2)}</span>
                `;
                cartItemsModal.appendChild(div);
            });
            totalPriceModal.textContent = "₱" + total.toFixed(2);
            cartTotalModal.style.display = 'flex';
            checkoutBtnModal.disabled = false;
        }

        // Change quantity
        function changeQty(index, delta) {
            cart[index].qty += delta;
            if (cart[index].qty <= 0) cart.splice(index, 1);
            updateCart();
        }

        // Remove item
        function removeItem(index) {
            cart.splice(index, 1);
            updateCart();
        }

        // Add to cart
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id,
                    name = btn.dataset.name,
                    price = parseFloat(btn.dataset.price);
                let existing = cart.find(i => i.id === id);
                if (existing) existing.qty++;
                else cart.push({
                    id,
                    name,
                    price,
                    qty: 1
                });
                updateCart();
            });
        });

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const category = btn.dataset.category;
                document.querySelectorAll('.menu-item').forEach(item => {
                    item.style.display = (category === 'all' || item.dataset.category === category) ? 'block' : 'none';
                });
            });
        });

        // Checkout Form Modal
        const checkoutFormModal = document.getElementById('checkoutModal');
        const checkoutForm = document.getElementById('checkoutForm');
        const tableInput = document.getElementById('tableNumber');
        const tableLabel = document.getElementById('tableLabel');
        const orderTypeSelect = document.getElementById('orderType');

        orderTypeSelect.addEventListener('change', () => {
            if (orderTypeSelect.value === 'dine_in') {
                tableInput.style.display = 'block';
                tableLabel.style.display = 'block';
                tableInput.required = true;
            } else {
                tableInput.style.display = 'none';
                tableLabel.style.display = 'none';
                tableInput.required = false;
            }
        });

        function closeCheckoutModal() {
            checkoutFormModal.style.display = 'none';
        }

        checkoutBtnModal.addEventListener('click', () => {
            if (cart.length === 0) return;
            checkoutFormModal.style.display = 'flex';
        });

        checkoutForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(checkoutForm);
            const data = {
                customer_name: formData.get('customer_name'),
                order_type: formData.get('order_type'),
                table_number: formData.get('table_number') || null,
                payment_method: formData.get('payment_method'),
                items: cart,
                total: cart.reduce((s, i) => s + i.price * i.qty, 0)
            };

            checkoutForm.querySelector('button[type="submit"]').disabled = true;
            checkoutForm.querySelector('button[type="submit"]').textContent = "Processing...";

            try {
                const response = await fetch("{{ route('orders.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                const result = await response.json();
                if (response.ok) {
                    alert(result.message);
                    cart = [];
                    updateCart();
                    closeCheckoutModal();
                    closeCartModal();
                } else {
                    alert(result.message || "Failed to place order.");
                }
            } catch (err) {
                console.error(err);
                alert("Something went wrong while placing the order.");
            } finally {
                checkoutForm.querySelector('button[type="submit"]').disabled = false;
                checkoutForm.querySelector('button[type="submit"]').textContent = "Place Order";
            }
        });
    </script>
</body>

</html>