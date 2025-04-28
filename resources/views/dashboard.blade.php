@extends('layouts.app')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Ecommerce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Orders -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Total Orders</h3>
                    <p class="text-3xl font-bold text-gray-600">245</p>
                </div>
                <!-- Total Revenue -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Total Revenue</h3>
                    <p class="text-3xl font-bold text-gray-600">$1,450</p>
                </div>
                <!-- Total Products -->
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Total Products</h3>
                    <p class="text-3xl font-bold text-gray-600">{{ count($products) }}</p>
                </div>
            </div>

            <!-- User Info and Role -->
            <div class="mt-6 bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800">User Profile</h3>
                <div class="mt-4 p-4 bg-gray-100 rounded">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Role:</strong>
                        @foreach(Auth::user()->getRoleNames() as $role)
                        <span class="px-2 py-1 bg-blue-500 text-black rounded">{{ $role }}</span>
                        @endforeach
                    </p>
                </div>
            </div>

            <!-- Latest Products -->
            <div class="mt-6 bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800">Latest Products</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    @foreach($products as $product)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover rounded-t-lg">
                        <h4 class="text-lg font-semibold text-gray-800 mt-2">{{ $product->name }}</h4>
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <span class="font-bold text-gray-700">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product->id) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded">View</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection