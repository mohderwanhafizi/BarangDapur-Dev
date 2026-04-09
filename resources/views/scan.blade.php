<form action="{{ route('products.storeGuest') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nama Barang" required>
    <input type="text" name="barcode" placeholder="Barcode (Optional)">
    <input type="number" name="quantity" value="1">
    <input type="email" name="email" placeholder="Emel Anda" required>
    <button type="submit">Simpan & Teruskan</button>
</form>