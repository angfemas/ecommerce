@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Profil Saya</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>role:</strong> {{ $user->role }}</li>
        <li class="list-group-item"><strong>Terdaftar Sejak:</strong> {{ $user->created_at->format('d M Y') }}</li>
    </ul>

    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>
</div>
@endsection