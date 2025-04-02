<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Pastikan role 'user' sudah ada, lalu assign
        if (Role::where('name', 'user')->exists()) {
            $user->assignRole('user');
        } else {
            Role::create(['name' => 'user']);
            $user->assignRole('user');
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}