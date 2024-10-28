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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();

            // Organization details...
            $table->string('organization_type', 100);
            $table->string('organization_name', 150);

            // Other Fields
            $table->string('asset_update_dates', 255)->nullable();
            $table->text('sugef_report')->nullable();
            $table->text('offer_form')->nullable();
            $table->text('catalog_or_website')->nullable();
            $table->text('vehicles_page')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
