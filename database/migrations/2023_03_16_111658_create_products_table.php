<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subsubcategory_id');
            $table->unsignedBigInteger('factory_id');
            $table->string('prod_name_en');
            $table->string('prod_name_ch');
            $table->string('prod_name_ru');
            $table->text('Desc_en');
            $table->text('Desc_ch');
            $table->text('Desc_ru');
            $table->boolean('state')->default(1);
            $table->foreign('subsubcategory_id')->references('id')->on('subsubcategories')->onDelete('cascade');
            $table->foreign('factory_id')->references('id')->on('factories')->onDelete('cascade'); //new
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }

};
