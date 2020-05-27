<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueKeySkuOnPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts', function(Blueprint $table)
        {
            $table->dropUnique('parts_sku_unique');
            $table->string('sku')->change()->nullable();
            $table->string('model_no')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parts', function(Blueprint $table)
        {
            $table->string('sku')->unique();
        });
    }
}
