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
        Schema::create('employee_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('task');
            $table->string('easypro_email');
            $table->string('easyu_user');
            $table->string('bienes_adjudicados_user');
            $table->string('intranet_user');
            $table->string('email_marketing_group');
            $table->string('phone_extension');
            $table->string('social_networks');
            $table->string('nas_access');
            $table->string('email_signature_card');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_checklists');
    }
};
