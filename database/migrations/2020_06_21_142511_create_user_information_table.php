<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('country',80)->nullable();
            $table->string('city',80)->nullable();
            $table->string('address',191)->nullable();
            $table->string('zip_code',80)->nullable();
            $table->string('language', 10)->nullable();
            $table->boolean('is_social_login')->default(false);
            $table->string('social_network_id', 180)->nullable();
            $table->string('social_network_type', 20)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_information');
    }
}
