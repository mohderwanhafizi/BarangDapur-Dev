<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductService
{
    public function saveGuestProduct(array $data, string $email): Product
    {
        return DB::transaction(function () use ($data, $email) {
            // Guna firstOrNew untuk elak Hash::make() dieksekusi jika user dah wujud
            $user = User::firstOrNew(['email' => $email]);

            if (! $user->exists) {
                $user->name = 'Guest User';
                $user->password = Hash::make(Str::random(16));
                $user->save();
            }

            // Simpan produk dan pautkan pada user
            return $user->products()->create([
                'name' => $data['name'],
                'barcode' => $data['barcode'] ?? null,
                'quantity' => $data['quantity'] ?? 1,
            ]);
        });
    }
}