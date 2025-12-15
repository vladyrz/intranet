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
        Schema::create('admin_reminders_plus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('frequency'); // daily, weekly, etc.
            $table->string('type'); // general, billing, etc.
            $table->text('content');

            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            // Scheduling & Status
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('next_run_at')->nullable();

            // Error Tracking
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
        Schema::dropIfExists('admin_reminders_plus');
    }
};
