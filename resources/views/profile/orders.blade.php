@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Riwayat Pesanan</h2>

    @forelse($orders as $order)
    <div class="card mb-3">
        <div class="card-header">
            Pesanan #{{ $order->id }} - Status: {{ ucfirst($order->status) }}
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Telepon:</strong> {{ $order->phone }}</p>
            <p><strong>Alamat
                    ::contentReference[oaicite:0]{index=0}