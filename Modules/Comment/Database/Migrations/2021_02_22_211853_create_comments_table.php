<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('guest_name')->nullable();
            $table->string('guest_contact')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');

            $table->text('comment');
            $table->unsignedBigInteger('parent_id')->default(0);

            $table->boolean('published')->default(0);
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
        Schema::dropIfExists('comments');
    }
}
