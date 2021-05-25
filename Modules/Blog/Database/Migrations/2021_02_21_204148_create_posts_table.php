<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog__posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            // $table->string('cover');            
            $table->string('template')->nullable();
            $table->tinyInteger('published')->default(0);
            $table->boolean('can_comment')->default(1);
            $table->timestamps();
        });

        Schema::create('blog__post_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('blog__posts')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('slug');
            $table->string('title')->nullable();
            $table->longText('content')->nullable();

            $table->unique(['post_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('blog__post_translations');
        Schema::dropIfExists('blog__posts');
        Schema::enableForeignKeyConstraints();
    }
}
