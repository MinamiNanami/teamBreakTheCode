<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - Jariel's Peak</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}" />
</head>
<body>
<div class="admin-container">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Jariel's Peak</h2>
            <button id="mobile-menu-toggle" class="mobile-menu-toggle">
                <span></span><span></span><span></span>
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
            <li data-section="blockchain-section"><a href="#">Blockchain & Tokens</a></li>
            <li data-section="logout"><a href="#">Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Dashboard -->
        <section id="dashboard" class="content-section active">
            <h1>Dashboard Summary</h1>
            <div class="dashboard-container">
                <div class="dashboard-left">
                    <div class="cards">
                        <div class="card"><h3>Total Users</h3><p id="total-users">0</p></div>
                        <div class="card"><h3>Total Products</h3><p id="total-products">0</p></div>
                        <div class="card"><h3>Total Orders</h3><p id="total-orders">0</p></div>
                        <div class="card"><h3>Total Token Transactions</h3><p id="total-transactions">0</p></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Manage Users -->
        <section id="users-section" class="content-section hidden">
            <h2>Manage Users</h2>
            <button id="create-user-btn">+ Create User</button>
            <div class="table-container">
                <table id="usersTable">
                    <thead>
                    <tr>
                        <th>Full Name</th><th>Email</th><th>Username</th><th>Role</th><th>Created At</th><th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="usersTableBody"></tbody>
                </table>
            </div>
        </section>

        <!-- Manage Products -->
        <section id="product-management" class="content-section hidden">
            <h2>Manage Products</h2>
            <button id="add-product-btn">+ Add Product</button>
            <div class="table-container">
                <table id="productTable">
                    <thead>
                    <tr>
                        <th>#</th><th>Name</th><th>Category</th><th>Price</th><th>Image</th><th>Status</th><th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="product-table-body"></tbody>
                </table>
            </div>
        </section>

        <!-- Sales Dashboard -->
        <section id="pos" class="content-section hidden">
            <h2>Sales Dashboard</h2>
            <div id="sales-chart-container"></div>
        </section>

        <!-- Transactions -->
        <section id="transactions" class="content-section hidden">
            <h2>Transactions</h2>
            <table id="transactions-table">
                <thead>
                <tr><th>ID</th><th>From</th><th>To</th><th>Amount</th><th>Date</th></tr>
                </thead>
                <tbody id="transactions-tbody"></tbody>
            </table>
        </section>

        <!-- Inventory -->
        <section id="inventory" class="content-section hidden">
            <h2>Inventory Management</h2>
            <button id="add-ingredient-btn">+ Add Ingredient</button>
            <table id="inventory-table">
                <thead>
                <tr><th>Ingredient Name</th><th>Stock</th><th>Unit</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody id="inventory-tbody"></tbody>
            </table>
        </section>

        <!-- Wallet Management -->
        <section id="wallet" class="content-section hidden">
            <h2>Wallet Management</h2>
            <div id="wallet-list"></div>
        </section>

        <!-- Load Request Approval -->
        <section id="load-approval" class="content-section hidden">
            <h2>Load Request Approval</h2>
            <table id="load-requests-table">
                <thead>
                <tr><th>User</th><th>Email</th><th>Amount</th><th>Date</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody id="load-requests-tbody"></tbody>
            </table>

            <!-- Modal -->
            <div id="approval-modal" class="modal hidden">
                <div class="modal-content">
                    <span class="close-btn" id="close-approval-modal">&times;</span>
                    <h3>Process Load Request</h3>
                    <div>
                        <label>User:</label> <span id="modal-user-name"></span><br>
                        <label>Email:</label> <span id="modal-user-email"></span><br>
                        <label>Amount:</label> <span id="modal-amount"></span><br>
                        <label>Date:</label> <span id="modal-request-date"></span><br>
                    </div>
                    <textarea id="approval-notes" placeholder="Add notes..."></textarea>
                    <button id="approve-request-btn">✅ Approve</button>
                    <button id="reject-request-btn">❌ Reject</button>
                    <button id="cancel-approval-btn">Cancel</button>
                </div>
            </div>
        </section>

        <!-- Blockchain & Token Management -->
        <section id="blockchain-section" class="content-section hidden">
            <h2>Blockchain & Token Management</h2>
            <div id="wallet-list"></div>
            <form id="token-action-form">
                <label>User:
                    <select id="token-user">
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Amount:
                    <input type="number" id="token-amount" min="1" step="1">
                </label>
                <label>Action:
                    <select id="token-action">
                        <option value="mint">Mint</option>
                        <option value="burn">Burn</option>
                    </select>
                </label>
                <button type="submit">Execute</button>
            </form>
        </section>

        <!-- Logout -->
        <section id="logout" class="content-section hidden">
            <h2>Logout</h2>
            <button id="confirm-logout-btn">Yes, Logout</button>
            <button id="cancel-logout-btn">Cancel</button>
        </section>

    </main>
</div>

<script src="{{ asset('js/admin-script.js') }}"></script>
<script src="{{ asset('js/sales_dashboard.js') }}"></script>
</body>
</html>
