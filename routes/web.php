<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;

// 🔹 Halaman utama untuk guest
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔹 Autentikasi
require __DIR__.'/auth.php';

// 🔹 Registrasi User
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// 🔹 Login dengan Google
Route::get('/auth/google', fn() => Socialite::driver('google')->redirect())->name('google.login');

Route::get('/auth/google/callback', function () {
    // ✅ FIX: Menghindari InvalidStateException saat develop di localhost
    $googleUser = Socialite::driver('google')->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt(str()->random(16)),
            'google_id' => $googleUser->getId(),
        ]);

        // ✅ Tambahkan role 'user' secara default
        $defaultRole = Role::firstOrCreate(['name' => 'user']);
        $user->assignRole($defaultRole);
    }

    Auth::login($user);
    return redirect()->route('dashboard');
});


// 🔹 Dashboard & Profil (Hanya untuk pengguna yang login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

     Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');

    // 🔹 Daftar produk hanya untuk yang sudah login
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 🔹 Keranjang Belanja dan Status Pemesanan
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/order-status/{orderId}', [CartController::class, 'checkStatus'])->name('order.status');
});

// 🔹 Admin Panel (Hanya Admin & Owner yang bisa akses)
Route::middleware(['auth', 'role:admin|owner'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/manage-users', [RoleController::class, 'index'])->name('manage.users');
    Route::post('/manage-users/{id}', [RoleController::class, 'assignRole'])->name('assign.role');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');