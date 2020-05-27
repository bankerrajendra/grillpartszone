<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNotNeededFieldsFromPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropColumn('is_tax_free');
            $table->dropColumn('is_free_ship');
            $table->dropColumn('has_qr_code');
            $table->dropColumn('is_available_online');
            $table->dropColumn('is_available_store');
            $table->dropColumn('date_available');
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
            $table->date('date_available')->nullable()->after('diameter');
            $table->boolean('is_available_store')->default(0)->after('diameter');
            $table->boolean('is_available_online')->default(0)->after('diameter');
            $table->boolean('has_qr_code')->default(0)->after('diameter');
            $table->boolean('is_free_ship')->default(0)->after('diameter');
            $table->boolean('is_tax_free')->default(0)->after('diameter');
        });
    }
}
