<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financial_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('financial_control_id')
                ->constrained('financial_controls')
                ->cascadeOnDelete();

            // Currency
            $table->string('currency', 3)->default('usd');

            // Amount of the movement
            $table->decimal('amount', 15, 2);

            // Movement date
            $table->date('movement_date');

            // Balance after the movement
            $table->decimal('balance', 15, 2);

            // Notes / observation
            $table->text('observation')->nullable();

            $table->timestamps();

            $table->index('movement_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_movements');
    }
};
