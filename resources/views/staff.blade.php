<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jariel's Peak - Staff Panel</title>

    <!-- html5-qrcode CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a8e6a3 0%, #88d982 35%, #7dd87a 100%);
            color: #2d4a2d;
            line-height: 1.6;
            min-height: 100vh;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 0 0 24px 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin: 0 20px 30px 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            height: 60px;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(135deg, #2e7d32, #388e3c);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .cart-btn {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
            transition: all 0.3s ease;
        }

        .cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.5);
        }

        .cart-count {
            background: rgba(255, 255, 255, 0.3);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
        }

        main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .top-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 20px;
        }

        .scanner-container,
        .current-order {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .scanner-container h3,
        .current-order h2 {
            margin: 0 0 20px 0;
            color: #2e7d32;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #qr-scanner {
            border: 3px dashed #4caf50;
            border-radius: 16px;
            height: 280px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            font-size: 16px;
            color: #666;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }

        #qr-scanner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(76, 175, 80, 0.1), transparent);
            transform: rotate(-45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(-45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(-45deg);
            }
        }

        .toggle-scanner-btn {
            position: absolute;
            bottom: 25px;
            left: 30px;
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
        }

        .current-order .order-items {
            flex-grow: 1;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item .order-actions button {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            border: none;
            color: white;
            padding: 4px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-left: 5px;
        }

        .order-total {
            font-weight: 700;
            font-size: 28px;
            margin: 20px 0;
            color: #2e7d32;
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(102, 187, 106, 0.1));
            border-radius: 16px;
            border: 2px solid rgba(76, 175, 80, 0.2);
        }

        .checkout-btn {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            border: none;
            padding: 16px 0;
            font-weight: 700;
            color: white;
            border-radius: 50px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .categories {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 10px;
        }

        .category-btn {
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #2e7d32;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-btn.active,
        .category-btn:hover {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            transform: translateY(-2px);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .product-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 15px;
        }

        .product-card h4 {
            margin: 0 0 10px 0;
            font-size: 18px;
            font-weight: 700;
        }

        .product-card p {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
            color: #4caf50;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal .modal-content {
            background: white;
            border-radius: 24px;
            padding: 30px;
            width: 400px;
            max-width: 90%;
            position: relative;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            max-height: 90%;
            overflow-y: auto;
        }

        .modal h2 {
            margin-top: 0;
            color: #2e7d32;
            text-align: center;
        }

        .modal input,
        .modal select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .modal .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .modal .modal-actions button {
            padding: 12px 20px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
        }

        .modal .cancel-btn {
            background: #ccc;
            color: white;
        }

        .modal .confirm-btn {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
        }

        #checkoutModal #summaryItems div,
        #addProductModal #summaryItems div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <h1>Jariel's Peak</h1>
            </div>
            <div style="display:flex; gap:10px;">
                <button id="addProductBtn" class="cart-btn"><i class="fas fa-plus"></i> Add New Product</button>
                <button class="cart-btn">
                    <i class="fas fa-shopping-cart"></i> Cart <span class="cart-count" id="cartCount">0</span>
                </button>
            </div>
        </div>
    </header>

    <main>
        <div class="top-section">
            <div class="scanner-container">
                <h3><i class="fas fa-qrcode"></i> QR Scanner</h3>
                <div id="qr-scanner">QR Scanner Here</div>
                <button class="toggle-scanner-btn" id="toggleScanner">Toggle Scanner</button>
            </div>

            <div class="current-order">
                <h2><i class="fas fa-receipt"></i> Current Order</h2>
                <div class="order-items" id="orderItems"></div>
                <div class="order-total" id="orderTotal">₱0.00</div>
                <button class="checkout-btn" id="checkoutBtn"><i class="fas fa-check"></i> Checkout</button>
            </div>
        </div>

        <div class="categories">
            <button class="category-btn active" data-category="all">All</button>
            <button class="category-btn" data-category="food">Food</button>
            <button class="category-btn" data-category="drinks">Drinks</button>
            <button class="category-btn" data-category="snacks">Snacks</button>
            <button class="category-btn" data-category="desserts">Desserts</button>
        </div>

        <div class="product-grid" id="productGrid">
            @foreach($items as $item)
            @php $pImg = !empty($item->image) ? asset('storage/'.$item->image) : asset('images/no-image.png'); @endphp
            <div class="product-card" data-category="{{ $item->category }}" data-id="{{ $item->id }}">
                <img src="{{ $pImg }}" alt="{{ $item->name }}">
                <h4>{{ $item->name }}</h4>
                <p>₱{{ number_format($item->price,2) }}</p>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <h2>Order Details</h2>
            <input type="text" id="modalCustomerName" placeholder="Customer Name" required>
            <select id="modalTableNumber">
                <option value="">Select Table Number</option>
                <option value="1">Table 1</option>
                <option value="2">Table 2</option>
                <option value="3">Table 3</option>
            </select>
            <select id="modalOrderMethod" required>
                <option value="">Select Order Method</option>
                <option value="dine-in">Dine-in</option>
                <option value="takeout">Takeout</option>
            </select>
            <select id="modalPaymentMethod" required>
                <option value="">Select Payment Method</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
            </select>

            <div id="modalOrderSummary" style="margin-top:20px; border-top:1px solid #ccc; padding-top:10px;">
                <h3 style="margin:0 0 10px 0; color:#4caf50;">Summary</h3>
                <div id="summaryItems"></div>
                <div id="summaryTotal" style="margin-top:10px; font-weight:700; text-align:right; color:#2e7d32;">Total: ₱0.00</div>
            </div>

            <div class="modal-actions">
                <button id="cancelCheckout" class="cancel-btn">Cancel</button>
                <button id="confirmCheckout" class="confirm-btn">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <h2>Add New Product</h2>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" id="newProductName" placeholder="Product Name" required>
                <input type="number" name="price" id="newProductPrice" placeholder="Price" required min="0" step="0.01">
                <select name="category" id="newProductCategory" required>
                    <option value="">Select Category</option>
                    <option value="food">Food</option>
                    <option value="drinks">Drinks</option>
                    <option value="snacks">Snacks</option>
                    <option value="desserts">Desserts</option>
                </select>
                <input type="file" name="image" id="newProductImage" accept="image/*">
                <div class="modal-actions">
                    <button type="button" id="cancelAddProduct" class="cancel-btn">Cancel</button>
                    <button type="submit" class="confirm-btn">Add</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let cart = [];
        const cartCount = document.getElementById('cartCount');
        const orderItems = document.getElementById('orderItems');
        const orderTotal = document.getElementById('orderTotal');

        function addToCart(item) {
            const existing = cart.find(i => i.id === item.id);
            if (existing) existing.qty++;
            else cart.push({
                ...item,
                qty: 1
            });
            renderCart();
            renderSummary();
        }

        function updateQty(itemId, action) {
            const item = cart.find(i => i.id === itemId);
            if (!item) return;
            if (action === 'increase') item.qty++;
            if (action === 'decrease') item.qty--;
            if (item.qty <= 0) cart = cart.filter(i => i.id !== itemId);
            renderCart();
            renderSummary();
        }

        function removeItem(itemId) {
            cart = cart.filter(i => i.id !== itemId);
            renderCart();
            renderSummary();
        }

        function renderCart() {
            orderItems.innerHTML = '';
            let total = 0;
            cart.forEach(i => {
                const div = document.createElement('div');
                div.classList.add('order-item');
                div.innerHTML = `
                <span>${i.name} x${i.qty}</span>
                <span>₱${(i.price*i.qty).toFixed(2)}</span>
                <div class="order-actions">
                    <button onclick="updateQty(${i.id}, 'increase')">+</button>
                    <button onclick="updateQty(${i.id}, 'decrease')">-</button>
                    <button onclick="removeItem(${i.id})">✕</button>
                </div>
            `;
                orderItems.appendChild(div);
                total += i.price * i.qty;
            });
            cartCount.textContent = cart.reduce((a, b) => a + b.qty, 0);
            orderTotal.textContent = `₱${total.toFixed(2)}`;
        }

        function renderSummary() {
            const summaryItems = document.getElementById('summaryItems');
            const summaryTotal = document.getElementById('summaryTotal');
            summaryItems.innerHTML = '';
            let total = 0;
            cart.forEach(i => {
                const div = document.createElement('div');
                div.innerHTML = `            <span>${i.name} x${i.qty}</span> <span>₱${(i.price*i.qty).toFixed(2)}</span>`;
                summaryItems.appendChild(div);
                total += i.price * i.qty;
            });
            summaryTotal.textContent = `Total: ₱${total.toFixed(2)}`;
        }

        // Product card click
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', () => {
                addToCart({
                    id: parseInt(card.dataset.id),
                    name: card.querySelector('h4').textContent,
                    price: parseFloat(card.querySelector('p').textContent.replace('₱', ''))
                });
            });
        });

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const cat = btn.dataset.category;
                document.querySelectorAll('.product-card').forEach(card => {
                    card.style.display = (cat === 'all' || card.dataset.category === cat) ? 'block' : 'none';
                });
            });
        });

        // Toggle QR Scanner
        document.getElementById('toggleScanner').addEventListener('click', () => {
            const scanner = document.getElementById('qr-scanner');
            scanner.style.display = scanner.style.display === 'none' ? 'flex' : 'none';
        });

        // Checkout modal
        const checkoutBtn = document.getElementById('checkoutBtn');
        const checkoutModal = document.getElementById('checkoutModal');
        const cancelCheckout = document.getElementById('cancelCheckout');
        const confirmCheckout = document.getElementById('confirmCheckout');

        checkoutBtn.addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Cart is empty!');
                return;
            }
            renderSummary();
            checkoutModal.style.display = 'flex';
        });

        cancelCheckout.addEventListener('click', () => {
            checkoutModal.style.display = 'none';
        });

        confirmCheckout.addEventListener('click', () => {
            const customerName = document.getElementById('modalCustomerName').value.trim();
            const tableNumber = document.getElementById('modalTableNumber').value.trim();
            const orderMethod = document.getElementById('modalOrderMethod').value;
            const paymentMethod = document.getElementById('modalPaymentMethod').value;

            if (!customerName || !tableNumber || !orderMethod || !paymentMethod) {
                alert('Please fill all details!');
                return;
            }

            console.log({
                customerName,
                tableNumber,
                orderMethod,
                paymentMethod,
                cart
            });

            alert('Order placed successfully!');
            cart = [];
            renderCart();
            checkoutModal.style.display = 'none';
            document.getElementById('modalCustomerName').value = '';
            document.getElementById('modalTableNumber').value = '';
            document.getElementById('modalOrderMethod').value = '';
            document.getElementById('modalPaymentMethod').value = '';
        });

        // Add Product modal toggle
        const addProductBtn = document.getElementById('addProductBtn');
        const addProductModal = document.getElementById('addProductModal');
        const cancelAddProduct = document.getElementById('cancelAddProduct');

        addProductBtn.addEventListener('click', () => {
            addProductModal.style.display = 'flex';
        });

        cancelAddProduct.addEventListener('click', () => {
            addProductModal.style.display = 'none';
        });

        // Close modal when clicking outside content
        window.addEventListener('click', (e) => {
            if (e.target === addProductModal) addProductModal.style.display = 'none';
            if (e.target === checkoutModal) checkoutModal.style.display = 'none';
        });
    </script>

</body>

</html>