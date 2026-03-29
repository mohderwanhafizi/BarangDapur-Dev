<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke user. Nullable sebab 'Quick Add' (Guest) tak ada ID lagi.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            
            // Maklumat Barang
            $table->string('name');
            $table->decimal('quantity', 12, 2)->default(0); // Guna decimal untuk berat/isipadu (cth: 1.5kg)
            $table->string('unit'); // kg, g, ml, liter, bungkus, botol
            $table->string('sku')->nullable()->index(); // Index untuk carian pantas barcode
            
            // Tarikh & Tempoh
            $table->date('expired_date')->nullable();
            $table->date('purchased_date')->index(); // Default masa insert nanti kita set 'now'
            
            // Klasifikasi
            $table->string('type')->nullable(); // Contoh: Basah, Kering, Frozen
            $table->string('packaging_type'); // Contoh: Plastik, Botol, Tin
            $table->string('category'); // Contoh: Rempah, Sayur, Daging
            
            // Media
            $table->string('image_path')->nullable();
            
            // Alert System
            $table->decimal('low_stock_threshold', 12, 2)->default(1); // Bila tinggal berapa unit nak bagi reminder?
            $table->string('reminder_frequency')->default('weekly'); // hourly, daily, weekly
            
            // Untuk Guest 'Quick Add' (Email rujukan sebelum login)
            $table->string('guest_email')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
