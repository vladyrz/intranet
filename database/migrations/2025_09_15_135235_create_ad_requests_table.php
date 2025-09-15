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
        Schema::create('ad_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('platform');
            $table->text('ad_url');
            $table->string('target_age')->nullable();
            $table->text('target_location')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('additional_info')->nullable();

            $table->decimal('investment_amount', 15, 2);
            $table->json('payment_receipt')->nullable();

            $table->string('status')->default('pending');
            $table->unsignedInteger('messages_received')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('reach')->default(0);
            $table->unsignedInteger('link_clicks')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_requests');
    }
};
