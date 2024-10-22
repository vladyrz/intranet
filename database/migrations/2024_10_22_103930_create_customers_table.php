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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name', 255);
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('contact_preferences')->nullable();
            $table->date('initial_contact_date')->nullable();
            $table->string('customer_type')->nullable();
            $table->json('credid_information')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->boolean('financing')->default(false);
            $table->decimal('expected_commission', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
