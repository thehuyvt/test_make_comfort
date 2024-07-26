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
        if(!Schema::hasColumn('customers', 'gender')){
            Schema::table('customers', function (Blueprint $table) {
                $table->boolean('gender')->default(1)->after('address');
            });
        }

        if(!Schema::hasColumn('customers', 'status')){
            Schema::table('customers', function (Blueprint $table) {
                $table->boolean('status')->default(1)->after('gender');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(!Schema::hasColumn('customers', 'gender')){
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
        }
        if(!Schema::hasColumn('customers', 'status')){
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
