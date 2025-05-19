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
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('experience');
            $table->string('location');
            $table->string('availability_status');
            $table->string('assigned_active_properties', 5);
            $table->string('coordinated_visits', 5)->nullable();
            $table->string('active_leads_follow_up', 5)->nullable();
            $table->string('closed_deals', 5)->nullable();
            $table->json('additional_skills')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
