<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('prod_id');
            $table->foreign('prod_id')->references('id')->on('products');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->text('cover_image');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->unsignedBigInteger('size_id');
            $table->decimal('actual_price',10,2);
            $table->decimal('offer_price',10,2)->nullable();
            $table->integer('prod_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('product_name');
            $table->dropColumn('product_code');
            $table->dropColumn('cover_image');
            $table->dropColumn('color_id');
            $table->dropColumn('size_id');
            $table->dropColumn('actual_price');
            $table->dropColumn('offer_price');
            $table->dropColumn('prod_count');
        });
    }
}
