<?php
namespace App\Services;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Mengendalikan pendaftaran item baru.
     * Logik: Jika ada Auth::id(), simpan di user_id. 
     * Jika tidak, simpan email dalam guest_email.
     */
    public function store(array $data): Inventory
    {
        return DB::transaction(function () use ($data) {
            $payload = [
                'name'               => $data['name'],
                'quantity'           => $data['quantity'],
                'unit'               => $data['unit'],
                'sku'                => $data['sku'] ?? null,
                'expired_date'       => $data['expired_date'] ?? null,
                'purchased_date'     => $data['purchased_date'] ?? now()->toDateString(),
                'type'               => $data['type'],
                'packaging_type'     => $data['packaging_type'],
                'category'           => $data['category'],
                'low_stock_threshold' => $data['low_stock_threshold'] ?? 1,
                'reminder_frequency' => $data['reminder_frequency'] ?? 'weekly',
            ];

            if (Auth::check()) {
                $payload['user_id'] = Auth::id();
            } else {
                // Untuk 'Quick Add' fasa 1
                $payload['guest_email'] = $data['email'];
            }

            // Handle Image Upload jika ada
            if (isset($data['image'])) {
                $payload['image_path'] = $data['image']->store('inventory_images', 'public');
            }

            return Inventory::create($payload);
        });
    }

    /**
     * Pindahkan barang dari Guest Email ke User ID selepas login/register.
     */
    public function syncGuestItems(string $email, int $userId): void
    {
        Inventory::where('guest_email', $email)
            ->whereNull('user_id')
            ->update([
                'user_id' => $userId,
                'guest_email' => null
            ]);
    }

    /**
     * Dapatkan senarai inventori untuk pengguna yang sedang log masuk.
     * Menggunakan pagination untuk performance yang lebih baik.
     */
    public function getUserInventories(int $userId)
    {
        return Inventory::where('user_id', $userId)
            ->orderByRaw('expired_date IS NULL, expired_date ASC') // Yang nak expired duduk atas
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Kemaskini data inventori sedia ada.
     */
    public function update(Inventory $inventory, array $data): bool
    {
        return $inventory->update([
            'name'               => $data['name'],
            'quantity'           => $data['quantity'],
            'unit'               => $data['unit'],
            'sku'                => $data['sku'] ?? $inventory->sku,
            'expired_date'       => $data['expired_date'] ?? null,
            'type'               => $data['type'],
            'packaging_type'     => $data['packaging_type'],
            'category'           => $data['category'],
        ]);
    }
}