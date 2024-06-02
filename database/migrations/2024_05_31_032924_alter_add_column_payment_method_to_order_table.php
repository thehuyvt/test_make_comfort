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
        if(!Schema::hasColumn('orders', 'payment_method')){
            Schema::table('orders', function (Blueprint $table) {
                $table->boolean('payment_method')->nullable()->after('total');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasColumn('orders', 'payment_method')){
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
