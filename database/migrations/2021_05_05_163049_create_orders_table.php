<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('amount');
            $table->string('price');
            $table->string('total_tax');
            $table->bigInteger('coupon_id');
            $table->string('final_price');
            $table->enum('status', [ORDER_ON_HOLD, ORDER_PROCESSING, ORDER_COMPLETED, ORDER_REJECTED]);
            $table->string('delivery_charge');
            $table->bigInteger('payment_method_id');
            $table->string('coupon_discount');
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
        Schema::dropIfExists('orders');
    }
}
