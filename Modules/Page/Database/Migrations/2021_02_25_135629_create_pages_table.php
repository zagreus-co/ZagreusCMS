<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page__pages', function (Blueprint $table) {
            $table->id();
            $table->boolean('can_comment')->default(0);
            $table->boolean('display_in_header')->default(1);
            $table->boolean('published')->default(1);
            $table->string('template')->nullable();
            $table->timestamps();
        });

        Schema::create('page__page_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('locale')->index();
            $table->string('slug');
            $table->string('title')->nullable();
            $table->longText('content')->nullable();

            $table->unique(['page_id', 'locale']);
            $table->foreign('page_id')->references('id')->on('page__pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page__page_translations');
        Schema::dropIfExists('page__pages');
    }
}
