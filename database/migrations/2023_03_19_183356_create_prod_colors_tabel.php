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
        Schema::create('prod_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prod_id');
            $table->string('color_en');
            $table->string('color_ch');
            $table->string('color_ru');
            $table->timestamps();
            $table->foreign('prod_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prod_colors');
    }
};
