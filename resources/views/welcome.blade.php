<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Barang Dapur</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        /* Sedikit custom style untuk hilangkan scrollbar tapi masih boleh scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-100 antialiased font-sans">

    <div class="max-w-md mx-auto bg-white min-h-screen shadow-2xl relative flex flex-col">
        
        <header class="bg-emerald-600 text-white p-4 sticky top-0 z-50 shadow-md">
            <h1 class="text-xl font-bold text-center">🛒 Tambah Barang Dapur</h1>
            @auth
                <p class="text-xs text-center mt-1 opacity-80">Log masuk sebagai: {{ auth()->user()->name }}</p>
            @endauth
        </header>

        <main class="flex-1 overflow-y-auto no-scrollbar p-5 pb-24">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-5 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200 text-center">
                <button type="button" id="btn-scan" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold w-full shadow-sm hover:bg-blue-700 transition">
                    📷 Buka Kamera Scanner
                </button>
                
                <div id="reader" class="mt-4 hidden w-full rounded-lg overflow-hidden"></div>
                <p id="scan-status" class="text-xs text-gray-500 mt-2 hidden">Mencari maklumat produk dari Data.gov.my...</p>
            </div>

            <form action="{{ route('inventory.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU / Barcode</label>
                    <input type="text" name="sku" id="sku" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500" placeholder="Scan atau taip manual...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500" placeholder="Cth: Sos Cili Maggi">
                </div>

                <div class="flex gap-3">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kuantiti <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="quantity" required class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500" placeholder="0.00">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit <span class="text-red-500">*</span></label>
                        <select name="unit" id="unit" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="pcs">Pcs / Biji</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="g">Gram (g)</option>
                            <option value="liter">Liter (L)</option>
                            <option value="ml">Mililiter (ml)</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="category" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="Kering">Barang Kering</option>
                            <option value="Basah">Barang Basah</option>
                            <option value="Rempah">Rempah Ratus</option>
                            <option value="Susu">Tenusu</option>
                            <option value="Pencuci">Bahan Pencuci</option>
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bungkusan</label>
                        <select name="packaging_type" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="Botol">Botol</option>
                            <option value="Plastik">Plastik</option>
                            <option value="Tin">Tin</option>
                            <option value="Kotak">Kotak</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarikh Luput (Expired)</label>
                    <input type="date" name="expired_date" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500 text-gray-600">
                </div>

                @guest
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mt-4">
                    <label class="block text-sm font-medium text-blue-800 mb-1">E-mel Anda (Untuk rujukan sistem) <span class="text-red-500">*</span></label>
                    <p class="text-xs text-blue-600 mb-2">Masukkan e-mel supaya barang ini masuk ke akaun anda bila anda daftar nanti.</p>
                    <input type="email" name="email" required class="w-full border-blue-200 rounded-lg shadow-sm px-4 py-2 border focus:ring-blue-500 focus:border-blue-500" placeholder="nama@email.com">
                </div>
                @endguest

                <div class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-white p-4 border-t border-gray-200 z-50">
                    <button type="submit" class="w-full bg-emerald-600 text-white font-bold text-lg py-3 rounded-xl shadow-lg hover:bg-emerald-700 active:transform active:scale-95 transition-all">
                        Simpan Barang
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnScan = document.getElementById('btn-scan');
            const readerDiv = document.getElementById('reader');
            const skuInput = document.getElementById('sku');
            const nameInput = document.getElementById('name');
            const statusText = document.getElementById('scan-status');
            
            let html5QrcodeScanner = null;

            btnScan.addEventListener('click', async function () {
                // Trik Debugging: Uji sokongan kamera asas terlebih dahulu
                try {
                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        alert("Ralat Kritikal: Browser ini tidak menyokong fungsi kamera (getUserMedia).");
                        return;
                    }

                    // Cuba minta kebenaran kamera secara manual dulu untuk pancing prompt
                    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    // Matikan stream sejurus selepas kebenaran berjaya dipancing
                    stream.getTracks().forEach(track => track.stop());

                    if (readerDiv.classList.contains('hidden')) {
                        // Buka Scanner
                        readerDiv.classList.remove('hidden');
                        btnScan.innerText = "Tutup Kamera";
                        btnScan.classList.replace('bg-blue-600', 'bg-red-500');

                        html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
                            fps: 10, 
                            qrbox: {width: 250, height: 150},
                            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA] 
                        }, false);
                        
                        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                    } else {
                        // Tutup Scanner
                        if(html5QrcodeScanner) {
                            html5QrcodeScanner.clear();
                        }
                        readerDiv.classList.add('hidden');
                        btnScan.innerText = "📷 Buka Kamera Scanner";
                        btnScan.classList.replace('bg-red-500', 'bg-blue-600');
                    }
                } catch (error) {
                    alert("Gagal mengakses kamera: " + error.name + " - " + error.message);
                }
            });

            function onScanSuccess(decodedText, decodedResult) {
                html5QrcodeScanner.clear();
                readerDiv.classList.add('hidden');
                btnScan.innerText = "📷 Buka Kamera Scanner";
                btnScan.classList.replace('bg-red-500', 'bg-blue-600');

                skuInput.value = decodedText;
                
                let audio = new Audio('https://www.soundjay.com/button/sounds/beep-07.mp3');
                audio.play().catch(e => console.log("Audio tersekat"));

                fetchProductData(decodedText);
            }

            function onScanFailure(error) {
                // Biarkan kosong
            }

            function fetchProductData(sku) {
                statusText.classList.remove('hidden');
                
                fetch(`/api/scan-sku/${sku}`)
                    .then(response => response.json())
                    .then(data => {
                        statusText.classList.add('hidden');
                        if (data.success) {
                            nameInput.value = data.data.name;
                        } else {
                            alert("Produk tidak dijumpai di Data.gov.my");
                        }
                    })
                    .catch(error => {
                        statusText.classList.add('hidden');
                    });
            }
        });
    </script>
</body>
</html>