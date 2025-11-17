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
        Schema::table('collaboration_requests', function (Blueprint $table) {
            $table->string('currency_code', 3)->nullable()->after('personal_customer_id');
            $table->decimal('client_budget_usd', 15, 2)->default(0)->after('client_budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaboration_requests', function (Blueprint $table) {
            //
        });
    }
};
