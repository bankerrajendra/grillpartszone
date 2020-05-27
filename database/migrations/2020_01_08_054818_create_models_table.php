<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('old_id')->unique();
            $table->bigInteger('brand_id');
            $table->string('name', '255')->nullable();
            $table->string('model_number', '100')->nullable()->index();
            $table->string('item_number', '100')->nullable();
            $table->string('sku', '100')->nullable();
            $table->string('year', '50')->nullable();
            $table->string('note', '255')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('features')->nullable();
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
        Schema::dropIfExists('models');
    }
}
