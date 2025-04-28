@extends('layouts.app') {{-- Sesuaikan dengan layout utama kamu --}}

@section('content')
<div class="container mt-5">
    <h2>Edit Profil</h2>

    @if (session('status') === 'profile-updated')
    <div class="alert alert-success mt-3">
        Profil berhasil diperbarui.
    </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <hr class="my-5">

    {{-- Hapus Akun --}}
    <form method="POST" action="{{ route('profile.destroy') }}"
        onsubmit="return confirm('Yakin ingin menghapus akun?');">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="password" class="form-label">Konfirmasi Password untuk Hapus Akun</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password', 'userDeletion') is-invalid @enderror">
            @error('password', 'userDeletion')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-danger">Hapus Akun</button>
    </form>
</div>

@endsection