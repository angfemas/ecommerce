<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan untuk import model Product
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Ambil produk yang ada, misalnya produk terbaru
        $products = Product::all(); // Atau gunakan metode lain seperti latest() atau paginate()
        
        // Kirim data produk ke tampilan dashboard
        return view('dashboard', compact('products'));
    }
}