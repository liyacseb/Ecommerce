<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('categories');
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->text('description')->nullable();
            $table->text('cover_image');
            $table->text('image_1');
            $table->text('image_2')->nullable();
            $table->text('image_3')->nullable();
            $table->text('image_4')->nullable();
            $table->text('image_5')->nullable();
            $table->text('image_6')->nullable();
            $table->string('color_id');
            $table->string('size_id')->nullable();
            $table->unsignedBigInteger('tax_id')->default(0);
            $table->foreign('tax_id')->references('id')->on('taxes');
            $table->decimal('actual_price',10,2);
            $table->decimal('offer_price',10,2)->nullable();
            $table->integer('status')->default(1)->comment('1-active, 0- inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
