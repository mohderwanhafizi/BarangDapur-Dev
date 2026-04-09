<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductService
{
    public function saveGuestProduct(array $data, string $email): Product
    {
        return DB::transaction(function () use ($data, $email) {
            // Cari user atau cipta user baru jika emel tiada dalam sistem
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'Guest User', 
                    'password' => bcrypt(Str::random(16)) // Password rawak
                ] 
            );

            // Simpan produk dan pautkan pada user
            return $user->products()->create([
                'name' => $data['name'],
                'barcode' => $data['barcode'] ?? null,
                'quantity' => $data['quantity'] ?? 1,
            ]);
        });
    }
}