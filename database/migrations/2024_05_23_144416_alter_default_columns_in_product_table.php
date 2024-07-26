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
        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->string('thumb')->nullable()->change();
            $table->integer('old_price')->default(0)->change();
            $table->integer('sale_price')->default(0)->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }
};
