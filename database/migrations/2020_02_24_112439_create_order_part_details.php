<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPartDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_part_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('order_id')->nullable()->default(0);
            $table->integer('part_id')->nullable()->default(0);
            $table->integer('brand_id')->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(0);
            $table->float('part_price')->nullable()->default(0.00);
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
        Schema::dropIfExists('order_part_details');
    }
}
