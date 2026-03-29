<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Services\DataGovService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AuthController;

// 1. Halaman Utama: Login Page
Route::get('/', function () {
    // Jika user dah login, terus campak ke dashboard. Tak perlu tengok page login lagi.
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('login'); 
})->name('login');

// 2. Halaman Quick Add (Boleh diakses tanpa login)
Route::get('/tambah-pantas', function () {
    return view('welcome'); // Ini fail view kamera/scan yang kita buat mula-mula tu
})->name('quick-add');

// Route untuk simpan barang
Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');

// 3. Kumpulan Route User Berdaftar (Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
});

// 4. Route API untuk Scanner Barcode
Route::get('/api/scan-sku/{sku}', function (string $sku, DataGovService $dataGovService): JsonResponse {
    $product = $dataGovService->getProductBySku($sku);

    if ($product) {
        return response()->json([
            'success' => true,
            'data' => [
                'name' => $product['nama_produk'] ?? '',
                'category' => $product['kategori'] ?? '',
                'unit' => $product['unit'] ?? '',
            ]
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Produk tidak dijumpai.'], 404);
})->middleware('throttle:60,1');

// Route untuk Login Manual & Logout
Route::post('/login-manual', [AuthController::class, 'loginManual'])->name('login.manual');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---> TAMBAH DUA BARIS INI UNTUK GOOGLE SOCIALITE <---
Route::get('/auth/google/redirect', [AuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'callback'])->name('google.callback');