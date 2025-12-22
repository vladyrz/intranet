<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financial_controls', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Owner / Creditor
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Status
            $table->string('status')->default('active');

            // Type
            $table->string('type');

            // Currency & Amount (shared)
            $table->string('currency', 3)->default('usd');

            $table->decimal('amount', 15, 2)->default(0);

            // -------------------------
            // Type-specific fields
            // -------------------------

            // Loan
            $table->string('debtor')->nullable();

            // Invoice Advance
            $table->string('invoice_number')->nullable();
            $table->string('responsible_person')->nullable();

            // General description
            $table->string('description')->nullable();

            // Entry date
            $table->date('entry_date');

            // Observations / notes
            $table->text('observations')->nullable();

            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_controls');
    }
};
