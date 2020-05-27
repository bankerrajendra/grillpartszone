<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateDimensionsFieldsPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `parts` CHANGE `length` `length_1` INT NULL DEFAULT NULL, CHANGE `height` `height_1` INT NULL DEFAULT NULL, CHANGE `width` `width_1` INT NULL DEFAULT NULL, CHANGE `diameter` `diameter_1` INT NULL DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `parts` CHANGE `length_1` `length` FLOAT(11) NULL DEFAULT NULL, CHANGE `height_1` `height` FLOAT(11) NULL DEFAULT NULL, CHANGE `width_1` `width` FLOAT(11) NULL DEFAULT NULL, CHANGE `diameter_1` `diameter` FLOAT(11) NULL DEFAULT NULL;");
    }
}
