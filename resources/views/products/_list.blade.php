    <!-- Produk Section -->
    <section id="products" class="container bg-light mt-5" data-aos="fade-up">
        <h2 class="text-center mb-4">Daftar Produk</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Tambah Produk</a>

        @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4" data-aos="fade-up">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Produk">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></p>
                        <p class="card-text">{{ $product->description }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Detail</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <button class="btn btn-success add-to-cart" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-price="{{ $product->price }}">+
                        </button>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center">Tidak ada produk yang tersedia.</p>
        @endif
       
    </section>