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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('property_name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->decimal('offer_amount_usd', 15, 2)->nullable();
            $table->decimal('offer_amount_crc', 15, 2)->nullable();
            $table->string('status');
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->date('offer_date');
            $table->string('comission_percentage');
            $table->string('offer_currency');
            $table->decimal('commission_amount_usd', 15, 2)->nullable();
            $table->decimal('commission_amount_crc', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
