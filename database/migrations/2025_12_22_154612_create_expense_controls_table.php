<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();

            $table->string('status'); // Enum: active, cancelled, suspended
            $table->string('cost_type'); // Enum: frequency logic

            $table->date('payment_date');

            // Scheduling & Status
            $table->timestamp('next_run_at')->nullable();

            $table->string('currency'); // Enum: crc, usd
            $table->decimal('amount', 12, 2);
            $table->string('area'); // Enum: technology, hr, etc.

            $table->string('description');
            $table->text('details')->nullable();

            // Error Tracking (Shared logic)
            $table->timestamp('last_sent_at')->nullable();
            $table->integer('failure_count')->default(0);
            $table->text('last_error_message')->nullable();
            $table->longText('last_error_trace')->nullable();
            $table->timestamp('last_failed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_controls');
    }
};
