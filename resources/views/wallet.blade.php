<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jariel's Peak Wallet</title>
    <link rel="stylesheet" href="{{ asset('css/wallet-styles.css') }}" />
    <script defer src="{{ asset('js/wallet-script.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <div class="mountain-bg"></div>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="wallet-summary">
                <div class="wallet-icon"><i class="fas fa-wallet"></i></div>
                <h2>My Wallet</h2>
                <div class="token-balance">
                    <span class="amount" id="wallet-balance">{{ auth()->user()->wallet_balance ?? 0 }}</span>
                    <span class="currency">JPT</span>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul>
                    <li class="active" data-section="dashboard"><i class="fas fa-home"></i><span>Dashboard</span></li>
                    <li data-section="transactions"><i class="fas fa-history"></i><span>Transactions</span></li>
                    <li data-section="profile"><i class="fas fa-user"></i><span>Profile</span></li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
                <button id="logoutBtn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Dashboard -->
            <div id="dashboard-section" class="content-section active">
                <div class="wallet-card">
                    <div class="wallet-card-header">
                        <h3>Wallet Overview</h3>
                    </div>
                    <div class="wallet-card-balance">
                        <span class="amount" id="wallet-balance-dashboard">{{ auth()->user()->wallet_balance ?? 0 }}</span>
                        <span class="currency">JPT</span>
                    </div>
                    <div class="wallet-card-actions">
                        <button class="btn-action" onclick="showLoadWalletForm()"><i class="fas fa-plus-circle"></i>Load Wallet</button>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div id="transactions-section" class="content-section">
                <h1><i class="fas fa-history"></i> Transaction History</h1>
                <div class="transactions-list full" id="transaction-list">
                    @if($transactions->isEmpty())
                        <p>No transactions yet.</p>
                    @else
                        <ul>
                            @foreach($transactions as $transaction)
                                <li>{{ $transaction->description }} - {{ $transaction->amount }} JPT - {{ $transaction->created_at->format('M d, Y') }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Profile -->
            <div id="profile-section" class="content-section">
                <h1><i class="fas fa-user-circle"></i> Profile</h1>
                <div class="profile-content">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Avatar" class="profile-avatar" />
                        </div>
                        <div class="profile-info">
                            <h2 id="profile-name">{{ auth()->user()->name }}</h2>
                            <p id="profile-email">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="profile-details">
                        <div class="detail-card">
                            <h3>Basic Information</h3>
                            <div class="detail-item"><label>Full Name:</label>
                                <p id="user-name">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="detail-item"><label>Email:</label>
                                <p id="user-email">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="detail-item"><label>Account Type:</label>
                                <p>Wallet</p>
                            </div>

                            <form id="updateProfileForm" action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="edit-fullname">Full Name</label>
                                    <input type="text" id="edit-fullname" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                                </div>
                                <div class="form-group">
                                    <label for="edit-email">Email</label>
                                    <input type="email" id="edit-email" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn-send">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <div class="detail-card">
                            <h3>Change Password</h3>
                            <form id="changePasswordForm" action="{{ route('password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="current-password">Current Password</label>
                                    <input type="password" id="current-password" name="current_password" required />
                                </div>
                                <div class="form-group">
                                    <label for="new-password">New Password</label>
                                    <input type="password" id="new-password" name="password" required />
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn-send">Update Password</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Wallet Modal -->
    <div id="loadWalletModal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus-circle"></i>  Load Wallet</h3>
                <span class="close" onclick="closeLoadWalletForm()">&times;</span>
            </div>
            <form id="loadWalletForm" action="{{ route('wallet.load') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="load-amount">Amount to Load (JPT)</label>
                    <input type="number" id="load-amount" name="amount" min="1" step="1" required placeholder="Enter amount in JPT" />
                </div>
                <div class="form-group">
                    <label for="load-payment-method">Payment Method</label>
                    <select id="load-payment-method" name="payment_method" required>
                        <option value="cash">Cash</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="load-reference">Reference Number (Optional)</label>
                    <input type="text" id="load-reference" name="reference_number" placeholder="Transaction reference number" />
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeLoadWalletForm()">Cancel</button>
                    <button type="submit" class="btn-send">Load Wallet</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // You should implement showLoadWalletForm and closeLoadWalletForm in your JS file
        function showLoadWalletForm() {
            document.getElementById('loadWalletModal').style.display = 'block';
        }

        function closeLoadWalletForm() {
            document.getElementById('loadWalletModal').style.display = 'none';
        }

        // Sidebar nav switching (example)
        document.querySelectorAll('.sidebar-nav ul li').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.content-section').forEach(section => section.classList.remove('active'));
                document.querySelectorAll('.sidebar-nav ul li').forEach(li => li.classList.remove('active'));

                item.classList.add('active');
                const sectionId = item.getAttribute('data-section') + '-section';
                document.getElementById(sectionId).classList.add('active');
            });
        });
    </script>
</body>

</html>
