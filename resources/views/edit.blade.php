<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 antialiased font-sans">

    <div class="max-w-md mx-auto bg-white min-h-screen shadow-2xl relative flex flex-col">
        
        <header class="bg-blue-600 text-white p-4 sticky top-0 z-50 shadow-md flex items-center">
            <a href="{{ route('dashboard') }}" class="mr-3 text-2xl hover:opacity-75">←</a>
            <h1 class="text-xl font-bold">✏️ Edit Barang</h1>
        </header>

        <main class="flex-1 overflow-y-auto p-5 pb-24">
            
            <form action="{{ route('inventory.update', $inventory->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT') <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU / Barcode</label>
                    <input type="text" name="sku" value="{{ old('sku', $inventory->sku) }}" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500 bg-gray-50" readonly>
                    <p class="text-[10px] text-gray-400 mt-1">*SKU tidak boleh diubah selepas didaftarkan.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $inventory->name) }}" required class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex gap-3">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kuantiti <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="quantity" value="{{ old('quantity', floatval($inventory->quantity)) }}" required class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit <span class="text-red-500">*</span></label>
                        <select name="unit" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="pcs" {{ $inventory->unit == 'pcs' ? 'selected' : '' }}>Pcs / Biji</option>
                            <option value="kg" {{ $inventory->unit == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="g" {{ $inventory->unit == 'g' ? 'selected' : '' }}>Gram (g)</option>
                            <option value="liter" {{ $inventory->unit == 'liter' ? 'selected' : '' }}>Liter (L)</option>
                            <option value="ml" {{ $inventory->unit == 'ml' ? 'selected' : '' }}>Mililiter (ml)</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="Kering" {{ $inventory->category == 'Kering' ? 'selected' : '' }}>Barang Kering</option>
                            <option value="Basah" {{ $inventory->category == 'Basah' ? 'selected' : '' }}>Barang Basah</option>
                            <option value="Rempah" {{ $inventory->category == 'Rempah' ? 'selected' : '' }}>Rempah Ratus</option>
                            <option value="Susu" {{ $inventory->category == 'Susu' ? 'selected' : '' }}>Tenusu</option>
                            <option value="Pencuci" {{ $inventory->category == 'Pencuci' ? 'selected' : '' }}>Bahan Pencuci</option>
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bungkusan</label>
                        <select name="packaging_type" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="Botol" {{ $inventory->packaging_type == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Plastik" {{ $inventory->packaging_type == 'Plastik' ? 'selected' : '' }}>Plastik</option>
                            <option value="Tin" {{ $inventory->packaging_type == 'Tin' ? 'selected' : '' }}>Tin</option>
                            <option value="Kotak" {{ $inventory->packaging_type == 'Kotak' ? 'selected' : '' }}>Kotak</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarikh Luput (Expired)</label>
                    <input type="date" name="expired_date" value="{{ old('expired_date', $inventory->expired_date) }}" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500 text-gray-600">
                </div>
                
                <input type="hidden" name="type" value="{{ $inventory->type ?? 'Default' }}">

                <div class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white p-4 border-t border-gray-200 z-50">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold text-lg py-3 rounded-xl shadow-lg hover:bg-blue-700 active:transform active:scale-95 transition-all">
                        Kemaskini Barang
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>