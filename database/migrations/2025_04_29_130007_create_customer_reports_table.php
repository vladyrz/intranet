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
        Schema::create('customer_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name', 255);
            $table->string('national_id', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone_number', 40)->nullable();
            $table->string('property_name', 255)->nullable();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->decimal('budget_usd', 15, 2)->nullable();
            $table->decimal('budget_crc', 15, 2)->nullable();
            $table->boolean('financing')->default(false);
            $table->decimal('expected_commission_usd', 15, 2)->nullable();
            $table->decimal('expected_commission_crc', 15, 2)->nullable();
            $table->string('report_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_reports');
    }
};
