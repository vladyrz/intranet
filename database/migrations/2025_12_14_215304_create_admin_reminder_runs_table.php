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
        Schema::create('admin_reminder_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_reminder_id')->constrained()->cascadeOnDelete();

            $table->timestamp('run_at');
            $table->string('status'); // success, failed
            $table->text('error_message')->nullable();
            $table->longText('error_trace')->nullable();
            $table->string('channel')->nullable();
            $table->string('job_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_reminder_runs');
    }
};
