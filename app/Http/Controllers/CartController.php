<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        return view('cart.index');
    }

    public function checkout(Request $request)
    {
        // Ambil data JSON dari body request
        $data = json_decode($request->getContent(), true);
    
        // Validasi jika cart tidak ditemukan
        if (!isset($data['cart']) || !is_array($data['cart'])) {
            return response()->json(['error' => 'Cart tidak valid'], 400);
        }
    
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        // Hitung total harga
        $totalPrice = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $data['cart']));
    
        // 👉 Simpan data order ke database jika perlu
        // contoh:
        // Order::create([...]);
    
        // Buat parameter untuk Snap
        $transaction_details = [
            'order_id' => uniqid(),
            'gross_amount' => $totalPrice,
        ];
    
        $customer_details = [
            'first_name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ];
    
        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details
        ];
    
        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}    