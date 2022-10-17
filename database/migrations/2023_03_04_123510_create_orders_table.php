<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderCode', 50);
            $table->string('fullname', 100);
            $table->string('email', 100)->nullable();
            $table->char('phone',11);
            $table->string('address', 200);
            $table->enum('status', ['pending', 'completed', 'cancel','shipping','confirmed']);
            $table->enum('payment', ['at-home', 'bank']);
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('total_product');
            $table->integer('total');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
