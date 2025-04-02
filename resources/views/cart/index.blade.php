@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4">Keranjang Belanja</h2>

    <div class="row">
        <div class="col-md-8">
            <h4>Ringkasan Pesanan</h4>
            <ul id="cart-items" class="list-group"></ul>
            <p id="total-price" class="mt-3"><strong>Total Harga: Rp 0</strong></p>
        </div>

        <div class="col-md-4">
            <h4>Data Pemesan</h4>
            <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
            </form>
        </div>
    </div>
</div>

<button onclick="checkTransactionStatus()" class="btn btn-info mt-3" id="check-status-btn" style="display: none;">Check
    Status</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
function checkTransactionStatus() {
    let orderId = "{{ session('order_id') }}";

    if (!orderId) {
        alert("Order ID tidak ditemukan! Silakan lakukan checkout terlebih dahulu.");
        return;
    }

    fetch(`/order-status/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (!data.transaction_status) {
                alert("⚠️ Terjadi kesalahan, coba lagi.");
                return;
            }

            let statusMessage = `Status: ${data.transaction_status}`;
            if (data.transaction_status === "settlement") {
                statusMessage += "\n✅ Pembayaran berhasil!";
            } else if (data.transaction_status === "pending") {
                statusMessage += "\n⏳ Menunggu pembayaran...";
            } else {
                statusMessage += "\n❌ Transaksi gagal atau dibatalkan.";
            }

            alert(statusMessage);
        })
        .catch(error => {
            console.error("Error:", error);
            alert("⚠️ Gagal mengambil status transaksi.");
        });
}

document.addEventListener("DOMContentLoaded", function() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let cartList = document.getElementById("cart-items");
    let totalPriceEl = document.getElementById("total-price");

    function updateCartUI() {
        cartList.innerHTML = "";
        let totalPrice = 0;

        if (cart.length === 0) {
            cartList.innerHTML = "<li class='list-group-item text-center'>Keranjang masih kosong</li>";
        } else {
            cart.forEach((item, index) => {
                let price = parseFloat(item.price || 0);
                let quantity = parseInt(item.quantity || 1);
                let subtotal = price * quantity;
                totalPrice += subtotal;

                let listItem = document.createElement("li");
                listItem.className =
                    "list-group-item d-flex justify-content-between align-items-center";
                listItem.innerHTML = `
                    ${item.name} - Rp ${new Intl.NumberFormat('id-ID').format(price)} (x${quantity})
                    <button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Hapus</button>
                `;
                cartList.appendChild(listItem);
            });
        }

        totalPriceEl.innerHTML =
            `<strong>Total Harga: Rp ${new Intl.NumberFormat('id-ID').format(totalPrice)}</strong>`;
    }

    window.removeItem = function(index) {
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartUI();
    };

    updateCartUI();

    document.getElementById("checkout-form").addEventListener("submit", function(event) {
        event.preventDefault();

        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let phone = document.getElementById("phone").value;
        let address = document.getElementById("address").value;

        if (cart.length === 0) {
            alert("Keranjang masih kosong!");
            return;
        }

        let orderData = {
            name,
            email,
            phone,
            address,
            cart: cart
        };

        fetch("{{ url('/cart/checkout') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.snapToken) {
                    window.snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            alert("✅ Pembayaran berhasil!");
                            console.log(result);
                            localStorage.removeItem("cart");
                            sessionStorage.setItem("order_id", data.order_id);
                            document.getElementById("check-status-btn").style.display =
                                "block";
                            window.location.reload();
                        },
                        onPending: function(result) {
                            alert("⏳ Menunggu pembayaran...");
                            console.log(result);
                        },
                        onError: function(result) {
                            alert("❌ Pembayaran gagal!");
                            console.log(result);
                        }
                    });
                } else {
                    alert("⚠️ Terjadi kesalahan, coba lagi.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("⚠️ Terjadi kesalahan saat melakukan checkout.");
            });
    });

    // ✅ Menampilkan tombol check status jika ada order_id di sesi
    let orderId = "{{ session('order_id') }}";
    if (orderId) {
        document.getElementById("check-status-btn").style.display = "block";
    }
});
</script>

@endsection