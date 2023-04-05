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
            $table->foreign('option_id')->references('id')->on('option__options')->onDelete('cascade');
            
            $table->string('locale')->index();
            $table->string('name');
            $table->text('data');
            $table->json('default')->nullable();

            $table->unique(['option_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option__option_translations');
        Schema::dropIfExists('option__options');
    }
};
