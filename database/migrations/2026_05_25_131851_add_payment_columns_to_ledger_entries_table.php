<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ledger_entries', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('activity');
            $table->string('payment_mode')->nullable()->after('payment_type');
            $table->string('transaction_reference')->nullable()->after('payment_mode');
            $table->text('notes')->nullable()->after('transaction_reference');
        });
    }

    public function down(): void
    {
        Schema::table('ledger_entries', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'payment_mode', 'transaction_reference', 'notes']);
        });
    }
};