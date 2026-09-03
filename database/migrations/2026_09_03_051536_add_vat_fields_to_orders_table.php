<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->decimal('subtotal_amount', 12, 2)
                ->nullable()
                ->after('status');

            $table->decimal('vat_rate', 5, 2)
                ->nullable()
                ->after('subtotal_amount');

            $table->decimal('vat_amount', 12, 2)
                ->nullable()
                ->after('vat_rate');

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'subtotal_amount',
                'vat_rate',
                'vat_amount',
            ]);

        });
    }
};
