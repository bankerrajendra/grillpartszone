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
            $table->bigIncrements('order_id');
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('old_db_user_id')->nullable()->default(0);
            $table->timestamp('order_date')->nullable()->useCurrent();
            $table->float('amount')->default(0);
            $table->float('tax')->default(0)->nullable();
            $table->float('shipping_amount')->default(0)->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_company', 255)->nullable();
            $table->string('shipping_name', 100)->nullable();
            $table->string('shipping_address_1', 255)->nullable();
            $table->string('shipping_address_2', 255)->nullable();
            $table->char('shipping_mobile_number',191)->nullable();
            $table->integer('shipping_country_id')->unsigned()->nullable();
            $table->integer('shipping_state_id')->unsigned()->nullable();
            $table->integer('shipping_city_id')->unsigned()->nullable();
            $table->char('shipping_zip',20)->nullable();
            $table->string('shipping_comment',255)->nullable();
            $table->integer('payment_method')->nullable();
            $table->string('order_method',255)->nullable();
            $table->timestamp('promised_ship_date')->nullable();
            $table->text('transaction_information')->nullable();
            $table->text('transaction_error')->nullable();
            $table->boolean('canceled')->default(0);
            $table->string('coupon', 255)->nullable();
            $table->float('coupon_discount')->nullable();
            $table->string('ip_address', 255)->nullable();
            $table->float('product_total_amount')->nullable();
            $table->string('order_status', 255)->nullable();
            $table->boolean('canceled_by_user')->nullable();
            $table->string('currency',50)->nullable();
            $table->string('order_pending',100)->nullable();
            $table->string('shipping_message',255)->nullable();
            $table->string('ups_track_no',255)->nullable();
            $table->string('store_match',100)->nullable();
            $table->string('store_name',255)->nullable();
            $table->integer('ossuserid')->nullable();
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
