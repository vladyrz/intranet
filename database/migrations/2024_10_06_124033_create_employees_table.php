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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('contract_status')->default(true);
            $table->string('progress_status')->nullable();
            $table->string('job_position')->nullable();
            $table->string('national_id', 15)->nullable()->unique();
            $table->string('phone_number', 15)->nullable();
            $table->string('personal_email')->unique()->nullable();
            $table->string('profession')->nullable();
            $table->string('license_plate')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->date('birthday')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('credid')->nullable();
            $table->text('contract')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
