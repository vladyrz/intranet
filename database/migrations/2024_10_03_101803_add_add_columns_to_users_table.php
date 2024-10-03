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
        Schema::table('users', function (Blueprint $table) {
            $table->string('progress_status')->nullable();
            $table->string('job_position')->nullable();
            $table->string('national_id', 15)->nullable()->unique();
            $table->string('marital_status')->nullable();
            $table->string('profession')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('personal_email')->nullable();
            $table->string('license_plate')->nullable();
            $table->boolean('contract_status')->default(true);
            $table->date('birthday')->nullable();
            $table->text('credid')->nullable();
            $table->text('contract')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
        });
    }
};