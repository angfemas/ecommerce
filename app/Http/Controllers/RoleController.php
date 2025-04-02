<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.manage-users', compact('users', 'roles'));
    }

    public function assignRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $role = $request->input('role');

        // Cegah admin mengubah role owner
        if (auth()->user()->hasRole('admin') && $user->hasRole('owner')) {
            return back()->with('error', "Admin tidak bisa mengubah role Owner.");
        }

        // Pastikan role yang dipilih ada di database
        if (Role::where('name', $role)->exists()) {
            $user->syncRoles([$role]); // Hapus role lama & tambahkan yang baru
            return back()->with('success', "Role user berhasil diubah ke $role.");
        }

        return back()->with('error', "Role tidak ditemukan.");
    }
}