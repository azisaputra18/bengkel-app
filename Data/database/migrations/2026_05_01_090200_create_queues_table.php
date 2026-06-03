<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            
            // Data Kendaraan & Pelanggan
            $table->string('queue_number')->unique();
            $table->string('customer_name');
            $table->string('vehicle_id'); // Nomor Polisi
            
            // Relasi (Pastikan tabel services & mechanics sudah ada)
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('mechanic_id')->nullable()->constrained('mechanics')->onDelete('set null');
            
            // Status & Progress pengerjaan
            $table->enum('status', ['waiting', 'processing', 'completed'])->default('waiting');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            
            // Pembayaran
            $table->integer('total_price')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};