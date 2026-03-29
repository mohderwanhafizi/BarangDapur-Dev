<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DataGovService
{
    /**
     * Dapatkan maklumat produk berdasarkan SKU (Barcode).
     * Disimpan dalam cache selama 30 hari untuk jimatkan API call & lajukan sistem.
     */
    public function getProductBySku(string $sku): ?array
    {
        $cacheKey = "product_sku_{$sku}";

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($sku) {
            try {
                // Ganti URL ini dengan endpoint sebenar data.gov.my bila API spesifik dah ada
                // Contoh: Katalog harga barang
                $response = Http::timeout(5)->get('https://api.data.gov.my/v1/produk', [
                    'sku' => $sku
                ]);

                if ($response->successful() && $response->json('data')) {
                    return $response->json('data')[0]; // Ambil result pertama
                }

                return null;
            } catch (\Exception $e) {
                Log::error("Gagal mendapatkan data SKU {$sku} dari Data.gov.my: " . $e->getMessage());
                return null; // Return null supaya sistem tak crash
            }
        });
    }
}