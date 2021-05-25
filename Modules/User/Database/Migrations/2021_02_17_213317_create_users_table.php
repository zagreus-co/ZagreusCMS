<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('number')->nullable();
            $table->string('full_name');
            $table->string('password');
            $table->integer('role_id')->default(0);
            $table->rememberToken();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        // Schema::create('security_questions', function(Blueprint $table) {
        //     $table->id();
        //     $table->string('question');
        //     $table->string('answer');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
        // Schema::dropIfExists('security_questions');
    }
}
