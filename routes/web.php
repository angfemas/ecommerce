<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use Spatie\Permission\Models\Role;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Autentikasi
require __DIR__.'/auth.php';

// 🔹 Registrasi User
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// 🔹 Login dengan Google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => bcrypt(str()->random(16)),
            'google_id' => $googleUser->getId(),
        ]);
        $user->assignRole('user'); // Role default "user"
    }

    Auth::login($user);
    return redirect('/dashboard');
});

// 🔹 Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔹 Admin Panel (Hanya Admin & Owner yang bisa akses)
Route::middleware(['auth', 'role:admin|owner'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/manage-users', [RoleController::class, 'index'])->name('manage.users');
    Route::post('/admin/manage-users/{id}', [RoleController::class, 'assignRole'])->name('assign.role');
});