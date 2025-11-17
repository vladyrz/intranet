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
        Schema::table('third_party_properties', function (Blueprint $table) {
            $table->string('currency_code', 3)->nullable()->after('service_type');
            $table->decimal('monthly_amount_usd', 15, 2)->default(0)->after('monthly_amount');
            $table->decimal('sale_amount_usd', 15, 2)->default(0)->after('sale_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('third_party_properties', function (Blueprint $table) {
            //
        });
    }
};
