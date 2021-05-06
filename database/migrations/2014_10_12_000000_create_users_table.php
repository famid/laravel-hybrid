<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->tinyInteger('role')->default(USER_ROLE);
            $table->tinyInteger('status')->default(0);
            $table->string('email_verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone',25)->nullable();
            $table->string('phone_code',5)->nullable();
            $table->integer('phone_verification_code')->nullable();
            $table->tinyInteger('phone_verified')->default(PENDING_STATUS);
            $table->tinyInteger('email_verified')->default(PENDING_STATUS);
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
