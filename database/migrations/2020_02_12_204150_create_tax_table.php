<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration is specifically for  Canada's provinces. The tax will be applied on Canada's provinces only.
     * @return void
     */
    public function up()
    {
        Schema::create('tax', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('state_id'); // will make seeder to fetch all provinces of Canada only.
            $table->float('vat_percentage');
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
        Schema::dropIfExists('tax');
    }
}
