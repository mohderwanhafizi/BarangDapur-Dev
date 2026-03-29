<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'user_id', 'name', 'quantity', 'unit', 'sku', 
        'expired_date', 'purchased_date', 'type', 
        'packaging_type', 'category', 'image_path',
        'low_stock_threshold', 'reminder_frequency', 'guest_email'
    ];

    // Relationship ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}