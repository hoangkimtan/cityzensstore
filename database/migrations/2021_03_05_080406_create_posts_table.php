<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_title', 200);
            $table->string('post_thumb', 200);
            $table->string('slug', 200);
            $table->text('content');
            $table->enum('status', ['publish', 'pending']);
            $table->unsignedBigInteger('post_cat_id');
            $table->foreign('post_cat_id')->references('id')->on('post_cats')->onDelete('cascade');
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
        Schema::dropIfExists('posts');
    }
}
