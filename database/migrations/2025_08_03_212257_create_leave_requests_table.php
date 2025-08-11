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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('request_type');
            $table->text('observations')->nullable();
            $table->string('request_status')->default('pending');
            $table->string('vacation_balance')->nullable();

            $table->date('permission_date')->nullable();
            $table->string('permission_options')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_days')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
