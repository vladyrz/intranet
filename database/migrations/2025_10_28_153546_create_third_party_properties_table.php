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
        Schema::create('third_party_properties', function (Blueprint $table) {
            $table->id();

            // 1. Informacion de la propiedad
            $table->string('name');
            $table->string('status')->default('pending');
            $table->string('finca_number')->unique();

            // Ubicacion
            $table->foreignId('country_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('state_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();

            $table->text('address');
            $table->date('received_at');

            // Tipo de servicio y costo
            $table->string('service_type');
            $table->decimal('monthly_amount', 15, 2)->nullable();
            $table->decimal('sale_amount', 15, 2)->nullable();

            // Detalle y caracteristicas
            $table->text('details')->nullable();

            // 2. Responsables y contactos
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('personal_customer_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            // 3. Adjuntos (obligatorios): se guardan como rutas principales en la tabla
            $table->text('contract_path');
            $table->text('registry_study_path');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_party_properties');
    }
};
