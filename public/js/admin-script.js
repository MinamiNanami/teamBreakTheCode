document.addEventListener("DOMContentLoaded", function() {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // -------------------------------
    // Section Navigation
    // -------------------------------
    const sections = document.querySelectorAll(".content-section");
    const menuItems = document.querySelectorAll(".sidebar-menu li");

    menuItems.forEach(item => {
        item.addEventListener("click", () => {
            sections.forEach(sec => sec.classList.add("hidden"));
            sections.forEach(sec => sec.classList.remove("active"));
            const target = item.dataset.section;
            document.getElementById(target).classList.remove("hidden");
            document.getElementById(target).classList.add("active");
            menuItems.forEach(i => i.classList.remove("active"));
            item.classList.add("active");
        });
    });

    // -------------------------------
    // Users Management
    // -------------------------------
    function loadUsers() {
        fetch('/admin/users')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById("usersTableBody");
                tbody.innerHTML = "";
                data.forEach(user => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.username}</td>
                        <td>${user.role}</td>
                        <td>${user.created_at}</td>
                        <td>
                            <button onclick="editUser(${user.id})">Edit</button>
                            <button onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }
    loadUsers();

    // -------------------------------
    // Products Management
    // -------------------------------
    function loadProducts() {
        fetch('/admin/products')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById("product-table-body");
                tbody.innerHTML = "";
                data.forEach((product, index) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${index+1}</td>
                        <td>${product.name}</td>
                        <td>${product.category}</td>
                        <td>₱${product.price}</td>
                        <td><img src="${product.image}" width="50"></td>
                        <td>${product.status}</td>
                        <td>
                            <button onclick="editProduct(${product.id})">Edit</button>
                            <button onclick="deleteProduct(${product.id})">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }
    loadProducts();

    // -------------------------------
    // Add/Edit Product Modal
    // -------------------------------
    const addProductBtn = document.getElementById("add-product-btn");
    const productModal = document.getElementById("product-modal");
    const closeProductModal = document.getElementById("close-product-modal");
    const productForm = document.getElementById("product-form");

    addProductBtn.addEventListener("click", () => {
        productForm.reset();
        document.getElementById("modal-title").textContent = "Add Product";
        document.getElementById("product-id").value = "";
        productModal.classList.remove("hidden");
    });

    closeProductModal.addEventListener("click", () => {
        productModal.classList.add("hidden");
    });

    productForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const productId = document.getElementById("product-id").value;
        const name = document.getElementById("product-name").value;
        const category = document.getElementById("product-category").value;
        const price = document.getElementById("product-price").value;
        const image = document.getElementById("product-image").value;
        const status = document.getElementById("product-status").value;

        const url = productId ? `/admin/products/${productId}` : "/admin/products";
        const method = productId ? "PUT" : "POST";

        fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ name, category, price, image, status })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert(data.message || "Product saved successfully!");
                productForm.reset();
                productModal.classList.add("hidden");
                loadProducts();
            } else {
                alert(data.message || "Failed to save product.");
            }
        })
        .catch(err => console.error(err));
    });

    // -------------------------------
    // Inventory Management
    // -------------------------------
    function loadInventory() {
        fetch('/admin/inventory')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById("inventory-tbody");
                tbody.innerHTML = "";
                data.forEach(item => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.stock_amount}</td>
                        <td>${item.unit}</td>
                        <td>${item.status}</td>
                        <td>
                            <button onclick="editIngredient(${item.id})">Edit</button>
                            <button onclick="deleteIngredient(${item.id})">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }
    loadInventory();

    // -------------------------------
    // Wallet Management
    // -------------------------------
    function loadWallets() {
        fetch('/admin/wallets')
            .then(res => res.json())
            .then(data => {
                const walletList = document.getElementById("wallet-list");
                walletList.innerHTML = "";
                data.forEach(w => {
                    const div = document.createElement("div");
                    div.innerHTML = `<p>${w.user.name}: ₱${w.balance}</p>`;
                    walletList.appendChild(div);
                });
            });
    }
    loadWallets();

    // -------------------------------
    // Transactions
    // -------------------------------
    function loadTransactions() {
        fetch('/admin/transactions')
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById("transactions-tbody");
                tbody.innerHTML = "";
                data.forEach(t => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${t.id}</td>
                        <td>${t.from_user}</td>
                        <td>${t.to_user}</td>
                        <td>₱${t.amount}</td>
                        <td>${t.created_at}</td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }
    loadTransactions();

    // -------------------------------
    // Load Requests
    // -------------------------------
    function loadRequests() {
        fetch('/admin/load-requests')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("load-requests-tbody");
            tbody.innerHTML = "";
            data.forEach(req => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${req.user.name}</td>
                    <td>${req.user.email}</td>
                    <td>₱${req.amount}</td>
                    <td>${req.created_at}</td>
                    <td>${req.status}</td>
                    <td><button onclick="openModal(${req.id})">Process</button></td>
                `;
                tbody.appendChild(tr);
            });
        });
    }
    window.openModal = function(id) {
        fetch(`/admin/load-requests`)
        .then(res => res.json())
        .then(data => {
            const req = data.find(r => r.id == id);
            document.getElementById("modal-user-name").textContent = req.user.name;
            document.getElementById("modal-user-email").textContent = req.user.email;
            document.getElementById("modal-amount").textContent = `₱${req.amount}`;
            document.getElementById("modal-request-date").textContent = req.created_at;

            const modal = document.getElementById("approval-modal");
            modal.classList.remove("hidden");

            document.getElementById("approve-request-btn").onclick = () => {
                fetch(`/admin/load-requests/${id}/approve`, {
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': csrfToken}
                }).then(()=> { modal.classList.add("hidden"); loadRequests(); });
            };
            document.getElementById("reject-request-btn").onclick = () => {
                fetch(`/admin/load-requests/${id}/reject`, {
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': csrfToken}
                }).then(()=> { modal.classList.add("hidden"); loadRequests(); });
            };
            document.getElementById("cancel-approval-btn").onclick = () => {
                modal.classList.add("hidden");
            };
        });
    }
    loadRequests();

    // -------------------------------
    // Token Management
    // -------------------------------
    const tokenForm = document.getElementById("token-action-form");
    if(tokenForm){
        tokenForm.addEventListener("submit", function(e){
            e.preventDefault();
            const userId = document.getElementById("token-user").value;
            const amount = document.getElementById("token-amount").value;
            const action = document.getElementById("token-action").value;

            fetch(`/admin/tokens/${action}`, {
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({user_id:userId, amount:amount})
            }).then(res=>res.json())
            .then(data => alert(data.message || "Action completed!"));
        });
    }

    // -------------------------------
    // Logout
    // -------------------------------
    document.getElementById("confirm-logout-btn").addEventListener("click", function(){
        fetch("/logout", { method: "POST", headers:{'X-CSRF-TOKEN': csrfToken}})
        .then(()=> window.location.href="/login");
    });
    document.getElementById("cancel-logout-btn").addEventListener("click", function(){
        sections.forEach(sec => sec.classList.add("hidden"));
        document.getElementById("dashboard").classList.remove("hidden");
    });

});
