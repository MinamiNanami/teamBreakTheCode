<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Jariel's Peak</title>
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}" />
</head>

<body>
    <div class="admin-container">

        <!-- Notification Container -->
        <div id="notification-container"></div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Jariel's Peak</h2>
                <button id="mobile-menu-toggle" class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <ul class="sidebar-menu">
                <li class="active" data-section="dashboard"><a href="#">Dashboard Summary</a></li>
                <li data-section="users-section"><a href="#">Manage Users</a></li>
                <li data-section="product-management"><a href="#">Manage Products</a></li>
                <li data-section="pos"><a href="#">Sales Dashboard</a></li>
                <li data-section="transactions"><a href="#">Transactions</a></li>
                <li data-section="inventory"><a href="#">Inventory Management</a></li>
                <li data-section="wallet"><a href="#">Wallet Management</a></li>
                <li data-section="load-approval"><a href="#">Load Request Approval</a></li>
                <li data-section="blockchain-section">
                    <a href="#">
                        <span class="icon">🪙</span>
                        <span>Blockchain & Tokens</span>
                    </a>
                </li>
                <li data-section="logout">
                    <a href="#">
                        <span class="icon">🚪</span>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">

            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <h1>Dashboard Summary</h1>
                <div class="dashboard-container">
                    <div class="dashboard-left">
                        <div class="cards">
                            <div class="card">
                                <h3>Total Users</h3>
                                <p id="total-users">0</p>
                            </div>
                            <div class="card">
                                <h3>Total Products</h3>
                                <p id="total-products">0</p>
                            </div>
                            <div class="card">
                                <h3>Total Orders</h3>
                                <p id="total-orders">0</p>
                            </div>
                            <div class="card">
                                <h3>Total Token Transactions</h3>
                                <p id="total-transactions">0</p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-right">
                        <div class="dashboard-stats">
                            <div class="stat-card">
                                <h3>Total Sales</h3>
                                <p id="total-sales-dashboard">₱0.00</p>
                            </div>
                            <div class="stat-card">
                                <h3>Best Seller</h3>
                                <p id="best-seller">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Manage Users Section -->
            <section id="users-section" class="content-section hidden">
                <h2>Manage Users</h2>

                <div class="filter-bar">
                    <label for="roleFilter">Filter by Role:</label>
                    <select id="roleFilter">
                        <option value="all">All</option>
                        <option value="admin">Admin</option>
                        <option value="wallet">Wallet</option>
                        <option value="customer">Customer (Kiosk)</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <div class="user-controls">
                    <button id="create-user-btn">+ Create User</button>
                </div>

                <div class="table-container">
                    <table id="usersTable">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <!-- Dynamic rows go here -->
                        </tbody>
                    </table>
                </div>

                <!-- Create User Modal -->
                <div id="create-user-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" id="close-user-modal">&times;</span>
                        <h3>Create New User</h3>
                        <form id="create-user-form">
                            <label for="fullname">Full Name:</label>
                            <input type="text" id="fullname" name="fullname" required />

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required />

                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required />

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required />

                            <label for="role">Role:</label>
                            <select id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="kiosk">Kiosk</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>

                            <button type="submit">Create Account</button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Manage Products Section -->
            <section id="product-management" class="content-section hidden">
                <h2>Manage Products</h2>

                <div class="product-controls">
                    <button id="add-product-btn">+ Add Product</button>
                    <button id="test-add-product-modal-btn" style="background: #007bff; color: white; margin-left: 10px;">🧪 Test Add Product Modal</button>
                </div>

                <div class="table-container">
                    <table id="productTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="product-table-body">
                            <!-- Dynamic product rows will go here -->
                        </tbody>
                    </table>
                </div>

                <!-- Product Modal -->
                <div id="product-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" id="close-product-modal">&times;</span>
                        <h3 id="modal-title">Add Product</h3>
                        <form id="product-form">
                            <input type="hidden" name="product_id" id="product-id" />

                            <label>
                                Name:
                                <input type="text" name="name" id="product-name" required />
                            </label>
                            <label>
                                Description:
                                <textarea name="description" id="product-description" rows="3" placeholder="Enter product description..."></textarea>
                            </label>
                            <label>
                                Price:
                                <input type="number" name="price" id="product-price" step="0.01" min="0" required />
                            </label>
                            <label>
                                Category:
                                <select name="category" id="product-category" required>
                                    <option value="">Select Category</option>
                                    <option value="food">Food</option>
                                    <option value="drinks">Drinks</option>
                                    <option value="snacks">Snacks</option>
                                    <option value="desserts">Desserts</option>
                                </select>
                            </label>
                            <label>
                                Status:
                                <select name="status" id="product-status" required>
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </label>
                            <label>
                                Image URL:
                                <input type="file" name="image" id="newProductImage" accept="image/*">
                            </label>

                            <button type="submit">Save Product</button>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Sales Dashboard Section -->
            <section id="pos" class="content-section hidden">
                <h2>Sales Dashboard</h2>
                <div class="sales-container">
                    <div class="sales-header">
                        <div class="sales-filters">
                            <select id="sales-period-filter">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <input type="date" id="custom-start-date" class="date-input" style="display: none;">
                            <input type="date" id="custom-end-date" class="date-input" style="display: none;">
                            <button id="refresh-sales-btn" class="refresh-btn">🔄 Refresh</button>
                        </div>
                    </div>

                    <div class="sales-overview">
                        <div class="sales-stats">
                            <div class="stat-card">
                                <h4>Total Sales</h4>
                                <p id="total-sales">₱0.00</p>
                                <span class="change-indicator" id="sales-change">+0%</span>
                            </div>
                            <div class="stat-card">
                                <h4>Orders Processed</h4>
                                <p id="orders-processed">0</p>
                                <span class="change-indicator" id="orders-change">+0%</span>
                            </div>
                            <div class="stat-card">
                                <h4>Average Order Value</h4>
                                <p id="avg-order-value">₱0.00</p>
                                <span class="change-indicator" id="avg-change">+0%</span>
                            </div>
                            <div class="stat-card">
                                <h4>Top Selling Item</h4>
                                <p id="top-selling-item">-</p>
                                <span class="change-indicator" id="top-item-change">+0%</span>
                            </div>
                        </div>
                    </div>

                    <div class="sales-content">
                        <div class="sales-left">
                            <div class="sales-chart-container">
                                <h3>Sales Trend</h3>
                                <div class="chart-container" id="sales-chart">
                                    <!-- Chart will be rendered here -->
                                </div>
                            </div>

                            <div class="top-products">
                                <h3>Top Selling Products</h3>
                                <div class="products-list" id="top-products-list">
                                    <!-- Top products will be loaded here -->
                                </div>
                            </div>
                        </div>

                        <div class="sales-right">
                            <div class="recent-transactions">
                                <h3>Recent Transactions</h3>
                                <div class="transactions-list" id="recent-transactions">
                                    <!-- Recent transactions will be loaded here -->
                                </div>
                            </div>

                            <div class="sales-breakdown">
                                <h3>Sales by Category</h3>
                                <div class="category-breakdown" id="category-breakdown">
                                    <!-- Category breakdown will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Transactions Section -->
            <section id="transactions" class="content-section hidden">
                <h1>View Transactions</h1>
                <table id="transactions-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="transactions-tbody">
                        <!-- Transactions will be loaded here -->
                    </tbody>
                </table>
            </section>

            <!-- Inventory Management Section -->
            <section id="inventory" class="content-section hidden">
                <h2>Inventory Management</h2>

                <div class="inventory-container">
                    <div class="inventory-header">
                        <div class="inventory-stats">
                            <div class="stat-card">
                                <h4>Total Ingredients</h4>
                                <p id="total-ingredients">0</p>
                            </div>
                            <div class="stat-card">
                                <h4>Low Stock Items</h4>
                                <p id="low-stock-count">0</p>
                            </div>
                        </div>

                        <div class="inventory-controls">
                            <button id="add-ingredient-btn" class="add-btn">+ Add Ingredient</button>
                            <button id="refresh-inventory-btn" class="refresh-btn">🔄 Refresh</button>
                        </div>
                    </div>

                    <div class="inventory-table-container">
                        <div class="table-filters">
                            <select id="stock-filter">
                                <option value="all">All Stock Levels</option>
                                <option value="low">Low Stock</option>
                                <option value="normal">Normal Stock</option>
                            </select>
                            <input type="text" id="ingredient-search" placeholder="Search ingredients...">
                        </div>

                        <table id="inventory-table">
                            <thead>
                                <tr>
                                    <th>Ingredient Name</th>
                                    <th>Stock Amount</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inventory-tbody">
                                <!-- Inventory items will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add/Edit Ingredient Modal -->
                <div id="ingredient-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" id="close-ingredient-modal">&times;</span>
                        <h3 id="ingredient-modal-title">Add Ingredient</h3>
                        <form id="ingredient-form">
                            <input type="hidden" id="ingredient-id" name="ingredient_id">

                            <div class="form-group">
                                <label for="ingredient-name">Ingredient Name:</label>
                                <input type="text" id="ingredient-name" name="name" required>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="stock-amount">Stock Amount:</label>
                                    <input type="number" id="stock-amount" name="stock_amount" min="0" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="stock-unit">Unit:</label>
                                    <select id="stock-unit" name="unit" required>
                                        <option value="">Select Unit</option>
                                        <option value="kg">Kilograms (kg)</option>
                                        <option value="g">Grams (g)</option>
                                        <option value="l">Liters (L)</option>
                                        <option value="ml">Milliliters (ml)</option>
                                        <option value="pcs">Pieces (pcs)</option>
                                        <option value="packs">Packs</option>
                                        <option value="cans">Cans</option>
                                        <option value="bottles">Bottles</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="save-btn">Save Ingredient</button>
                                <button type="button" class="cancel-btn" id="cancel-ingredient-btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Wallet Management Section -->
            <section id="wallet" class="content-section hidden">
                <h2>Wallet Management</h2>

                <div class="wallet-container">
                    <!-- Send Token Form -->
                    <div class="wallet-card">
                        <div class="wallet-card-header">
                            <h3>Send Tokens</h3>
                            <p>Transfer tokens to other users</p>
                        </div>

                        <form id="send-token-form" class="wallet-form">
                            <div class="form-group">
                                <label for="recipient-input">
                                    <span class="label-text">Send To (username or email):</span>
                                    <input type="text" id="recipient-input" name="to" placeholder="Enter username or email" required>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="amount-input">
                                    <span class="label-text">Amount:</span>
                                    <div class="amount-input-wrapper">
                                        <span class="currency-symbol">₱</span>
                                        <input type="number" id="amount-input" name="amount" min="1" step="0.01" placeholder="0.00" required>
                                    </div>
                                </label>
                            </div>

                            <button type="submit" class="send-token-btn">
                                <span class="btn-icon">💸</span>
                                Send Token
                            </button>
                        </form>

                        <div id="wallet-message" class="wallet-message"></div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="wallet-stats">
                        <div class="stat-card">
                            <div class="stat-icon">💰</div>
                            <div class="stat-content">
                                <h4>Total Circulation</h4>
                                <p id="total-circulation">₱0.00</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon">👥</div>
                            <div class="stat-content">
                                <h4>Active Wallets</h4>
                                <p id="active-wallets">0</p>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon">📊</div>
                            <div class="stat-content">
                                <h4>Total Transactions</h4>
                                <p id="total-wallet-transactions">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Load Request Approval Section -->
            <section id="load-approval" class="content-section hidden">
                <h2>Load Request Approval</h2>

                <div class="load-approval-container">
                    <div class="approval-header">
                        <div class="approval-stats">
                            <div class="stat-card">
                                <div class="stat-icon">⏳</div>
                                <div class="stat-content">
                                    <h4>Pending Requests</h4>
                                    <p id="pending-requests-count">0</p>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">✅</div>
                                <div class="stat-content">
                                    <h4>Approved Today</h4>
                                    <p id="approved-today-count">0</p>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon">❌</div>
                                <div class="stat-content">
                                    <h4>Rejected Today</h4>
                                    <p id="rejected-today-count">0</p>
                                </div>
                            </div>
                        </div>

                        <div class="approval-controls">
                            <button id="refresh-approval-btn" class="refresh-btn">🔄 Refresh</button>
                        </div>
                    </div>

                    <div class="approval-table-container">
                        <div class="table-filters">
                            <select id="status-filter">
                                <option value="all">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <input type="text" id="request-search" placeholder="Search by username or email...">
                        </div>

                        <table id="load-requests-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Amount</th>
                                    <th>Request Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="load-requests-tbody">
                                <!-- Load requests will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Approval Modal -->
                <div id="approval-modal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn" id="close-approval-modal">&times;</span>
                        <h3 id="approval-modal-title">Process Load Request</h3>

                        <div class="request-details">
                            <div class="detail-row">
                                <label>User:</label>
                                <span id="modal-user-name">-</span>
                            </div>
                            <div class="detail-row">
                                <label>Email:</label>
                                <span id="modal-user-email">-</span>
                            </div>
                            <div class="detail-row">
                                <label>Amount:</label>
                                <span id="modal-amount">-</span>
                            </div>
                            <div class="detail-row">
                                <label>Request Date:</label>
                                <span id="modal-request-date">-</span>
                            </div>
                        </div>

                        <div class="approval-actions">
                            <div class="form-group">
                                <label for="approval-notes">Notes (Optional):</label>
                                <textarea id="approval-notes" placeholder="Add any notes about this request..."></textarea>
                            </div>

                            <div class="action-buttons">
                                <button type="button" id="approve-request-btn" class="approve-btn">
                                    <span class="btn-icon">✅</span>
                                    Approve Request
                                </button>
                                <button type="button" id="reject-request-btn" class="reject-btn">
                                    <span class="btn-icon">❌</span>
                                    Reject Request
                                </button>
                                <button type="button" id="cancel-approval-btn" class="cancel-btn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Blockchain & Token Management Section -->
            <section id="blockchain-section" class="content-section hidden">
                <h2>🪙 Blockchain & Token Management</h2>

                <div class="blockchain-dashboard">
                    <!-- Token Overview -->
                    <div class="token-overview">
                        <div class="stat-card">
                            <h4>Total Tokens Minted</h4>
                            <p id="total-tokens-minted">0 JPT</p>
                        </div>
                        <div class="stat-card">
                            <h4>Active Wallets</h4>
                            <p id="active-wallets">0</p>
                        </div>
                        <div class="stat-card">
                            <h4>Total Transactions</h4>
                            <p id="total-transactions">0</p>
                        </div>
                    </div>

                    <!-- Load Request Integration -->
                    <div class="load-approval-section">
                        <h3>💰 Load Request Approval with Token Conversion</h3>
                        <div class="approval-queue" id="approval-queue">
                            <!-- Load requests will be loaded here -->
                        </div>
                    </div>

                    <!-- Token Management -->
                    <div class="token-management">
                        <h3>🪙 Token Operations</h3>
                        <div class="token-actions">
                            <button id="mint-tokens-btn" class="btn-primary">Mint New Tokens</button>
                            <button id="burn-tokens-btn" class="btn-secondary">Burn Tokens</button>
                            <button id="transfer-tokens-btn" class="btn-success">Transfer Tokens</button>
                        </div>
                    </div>

                    <!-- Wallet Management Integration -->
                    <div class="wallet-management">
                        <h3>👛 Wallet Management</h3>
                        <div class="wallet-list" id="wallet-list">
                            <!-- Wallets will be loaded here -->
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="transaction-history">
                        <h3>📊 Transaction History</h3>
                        <div class="transactions-table" id="transactions-table">
                            <!-- Transactions will be loaded here -->
                        </div>
                    </div>
                </div>
            </section>

            <!-- Logout Section (Fixed) -->
            <section id="logout" class="content-section hidden">
                <h2>Logout</h2>

                <div class="logout-container">
                    <div class="logout-content">
                        <div class="logout-icon">
                            <span>🚪</span>
                        </div>
                        <h3>Are you sure you want to logout?</h3>
                        <p>You will be logged out of all active sessions. Make sure to save any unsaved changes.</p>

                        <div class="logout-actions">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn">Yes, Logout</button>
                            </form>
                            <button id="cancel-logout-btn" class="cancel-btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/admin-script.js') }}"></script>
    <script src="{{ asset('js/sales_dashboard.js') }}"></script>
</body>

</html>
