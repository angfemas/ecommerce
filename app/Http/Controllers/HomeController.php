<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua produk
        $products = Product::latest()->get();

        // Kirim ke view 'home'
        return view('home', compact('products'));
    }
}