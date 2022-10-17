<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_title', 200);
            $table->string('product_thumb', 255);
            $table->string('code', 100)->nullable();
            $table->string('slug')->nullable();
            $table->text('product_desc');
            $table->text('product_detail');
            $table->enum('tracking', ['stocking', 'out-of-stock']);
            $table->enum('status', ['publish', 'pending']);
            $table->unsignedBigInteger('product_cat_id');
            $table->enum('feature', [1, 0])->nullable();
            $table->foreign('product_cat_id')->references('id')->on('product_cats')->onDelete('cascade');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
