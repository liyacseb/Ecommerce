<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function($table) {
            $table->dropColumn('status');
        });
    }

    public function down()
    {
        Schema::table('carts', function($table) {
            $table->integer('status');
        });
    }
}
