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
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index('idempotency_key');
        });

        Schema::table('payout_requests', function (Blueprint $table) {
            $table->index('status');
            $table->index('idempotency_key');
        });

        Schema::table('ledger_entries', function (Blueprint $table) {
            $table->index('entry_type');
            $table->index('activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['idempotency_key']);
        });

        Schema::table('payout_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['idempotency_key']);
        });

        Schema::table('ledger_entries', function (Blueprint $table) {
            $table->dropIndex(['entry_type']);
            $table->dropIndex(['activity']);
        });
    }
};
