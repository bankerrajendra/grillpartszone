<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('sku')->unique();
            $table->string('model_no');
            $table->string('item_no')->nullable();
            $table->string('year', 5)->nullable();
            $table->string('note', 255)->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('features')->nullable();
            $table->double('price')->default(0.00);
            $table->double('retail_price')->default(0.00);
            $table->double('cost')->default(0.00);
            $table->integer('stock')->default(0);
            $table->string('weight', 20)->nullable();
            $table->integer('impression')->nullable();
            $table->integer('created_by')->nullable()->default(0);
            $table->double('length')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->double('diameter')->nullable();
            $table->boolean('is_tax_free')->default(0);
            $table->boolean('is_free_ship')->default(0);
            $table->boolean('has_qr_code')->default(0);
            $table->boolean('is_available_online')->default(0);
            $table->boolean('is_available_store')->default(0);
            $table->boolean('show_on_grillpartsgallery_com')->default(1);
            $table->boolean('show_on_bbqpartsfactory_com')->default(1);
            $table->boolean('show_on_bbqpartszone_com')->default(1);
            $table->boolean('is_active')->default(0);
            $table->date('date_available')->nullable();
            $table->string('meta_title', '1024')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('manual', 255)->nullable();
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
        Schema::dropIfExists('parts');
    }
}
