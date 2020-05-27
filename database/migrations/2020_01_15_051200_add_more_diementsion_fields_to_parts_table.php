<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreDiementsionFieldsToPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->double('length_2')->default(0.00)->after('length_1');
            $table->double('height_2')->default(0.00)->after('height_1');
            $table->double('width_2')->default(0.00)->after('width_1');
            $table->double('diameter_2')->default(0.00)->after('diameter_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropColumn('length_2');
            $table->dropColumn('height_2');
            $table->dropColumn('width_2');
            $table->dropColumn('diameter_2');
        });
    }
}
