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
        Schema::table('ad_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('ad_requests', 'stripe_session_id')) {
                $table->string('stripe_session_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('ad_requests', 'stripe_payment_status')) {
                $table->string('stripe_payment_status')->nullable()->after('stripe_session_id');
            }
            if (!Schema::hasColumn('ad_requests', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('stripe_payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad_requests', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('ad_requests', 'stripe_session_id')) {
                $columnsToDrop[] = 'stripe_session_id';
            }
            if (Schema::hasColumn('ad_requests', 'stripe_payment_status')) {
                $columnsToDrop[] = 'stripe_payment_status';
            }
            if (Schema::hasColumn('ad_requests', 'paid_at')) {
                $columnsToDrop[] = 'paid_at';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
