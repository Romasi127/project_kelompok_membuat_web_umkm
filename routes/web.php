<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminOrderController;

// 1. Root redirect to Menu Page
Route::redirect('/', '/menu');

// 2. Public Menu & Cart Routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{key}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');

// 3. User Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 4. Admin Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
    Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register']);
});
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// 5. Protected Customer (User) Routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders', [OrderController::class, 'myOrders'])->name('order.myOrders');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('/order/{id}/pdf', [OrderController::class, 'downloadPdf'])->name('order.pdf');
});

// 6. Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::delete('/orders', [AdminOrderController::class, 'destroyAll'])->name('orders.destroyAll');
    // Daily Revenue Report
    Route::get('/revenue', [AdminOrderController::class, 'revenue'])->name('revenue');
    // Menus (CRUD)
    Route::resource('menus', AdminMenuController::class)->except(['show']);
});

// ====================================================================
// ROUTE RAHASIA UNTUK MIGRASI DATABASE SQLITE DI RENDER (FREE TIER)
// ====================================================================
Route::get('/jalankan-migrasi-rahasia', function () {
    try {
        // Membuat file database kosong jika menggunakan SQLite dan file belum ada
        if (config('database.default') === 'sqlite') {
            $dbPath = database_path('database.sqlite');
            if (!file_exists($dbPath)) {
                touch($dbPath);
            }
        }
        
        // Menjalankan migrasi database dan mengisi data seeder otomatis
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        return "Mantap wak! Database berhasil dibuat dan data menu sudah masuk.";
    } catch (\Exception $e) {
        return "Waduh error: " . $e->getMessage();
    }
});
