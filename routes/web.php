<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoadRequestController;
use App\Http\Controllers\TokenController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('index') : redirect()->route('login');
});

// Dashboard route
Route::get('/dashboard', [TransactionController::class, 'wallet'])->name('dashboard');



Route::get('/staff', [StaffController::class, 'index']);


Route::post('/scan-qr', function (Request $request) {
    $qrCode = $request->input('qr_code');
    // Process the QR code - e.g., find product, add to order, etc.
    // For example, return a JSON response:
    return response()->json(['success' => true, 'message' => 'QR code processed', 'qr_code' => $qrCode]);
});

// Wallet route - this loads wallet page, named 'wallet.load'

Route::get('/wallet', [TransactionController::class, 'wallet'])->name('wallet.load');
Route::post('/wallet/load', [WalletController::class, 'load'])->name('wallet.load');    

Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/kiosk', [KioskController::class, 'index'])->name('kiosk.index');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');



Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('/reset_password', fn() => view('reset_password'))->name('reset_password');

Route::prefix('admin')->group(function() {
    // Load Requests
    Route::get('load-requests', [LoadRequestController::class,'index']);
    Route::post('load-requests/{id}/approve', [LoadRequestController::class,'approve']);
    Route::post('load-requests/{id}/reject', [LoadRequestController::class,'reject']);

    // Tokens
    Route::get('tokens', [TokenController::class,'index']);
    Route::post('tokens/mint', [TokenController::class,'mint']);
    Route::post('tokens/burn', [TokenController::class,'burn']);
    Route::post('tokens/transfer', [TokenController::class,'transfer']);
});


require __DIR__ . '/auth.php';
