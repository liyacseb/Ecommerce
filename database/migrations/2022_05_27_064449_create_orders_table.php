<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->id();
            $table->integer('payment_gateway')->comment('1-razorpay, 2-stripe,3-wallet, 4-cash on delivery');
            $table->unsignedBigInteger('coupon_id');
            $table->decimal('coupon_discount',10,2);
            $table->decimal('amount',10,2);
            $table->tinyInteger('payment_status')->comment('0-pending,1-paid,2-payment failed');
            $table->timestamp('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('name');
            $table->string('phone_number');
            $table->string('company')->nullable();
            $table->text('adrs_line_1');
            $table->text('adrs_line_2');
            $table->string('pincode');
            $table->string('district');
            $table->string('state');
            $table->string('country');
            $table->tinyInteger('adress_type')->default('0')->comment('0-home,1-work place');
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
        Schema::dropIfExists('orders');
    }
}
