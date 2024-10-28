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
        Schema::create('organization_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contact_type')->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_position', 100)->nullable();
            $table->string('contact_phone_number', 20)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_main_method')->nullable();
            $table->text('contact_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_contacts');
    }
};
