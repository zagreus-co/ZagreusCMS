<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option__options', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->string('type')->default('text');
            $table->text('plain_data')->nullable();
            $table->boolean('is_translatable')->default(1);
            $table->timestamps();
        });

        Schema::create('option__option_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('option_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('data');
            $table->json('default')->nullable();

            $table->unique(['option_id', 'locale']);
            $table->foreign('option_id')->references('id')->on('option__options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option__option_translations');
        Schema::dropIfExists('option__options');
    }
}
