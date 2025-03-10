<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('property_name');
            $table->decimal('property_value_usd', 15, 2)->nullable();
            $table->decimal('property_value_crc', 15, 2)->nullable();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('offer_amount_usd', 15, 2)->nullable();
            $table->decimal('offer_amount_crc', 15, 2)->nullable();
            $table->foreignId('personal_customer_id')->nullable()->constrained()->nullOnDelete();
            $table->json('offer_files')->nullable();
            $table->string('offer_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
