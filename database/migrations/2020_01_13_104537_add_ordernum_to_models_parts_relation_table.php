<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdernumToModelsPartsRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('models_parts_relation', function (Blueprint $table) {
            $table->integer('ordernum')->nullable()->after('part_id');
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
        Schema::table('models_parts_relation', function (Blueprint $table) {
            $table->dropColumn('ordernum');
        });
    }
}
