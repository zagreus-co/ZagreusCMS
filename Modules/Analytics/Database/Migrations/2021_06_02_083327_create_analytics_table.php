<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytics__data', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->integer('views')->default(1);
            $table->string('url');
            $table->string('route');
            $table->string('ip');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
        
        Schema::create('analytics__rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytics__data');
        Schema::dropIfExists('analytics__rules');
    }
}
