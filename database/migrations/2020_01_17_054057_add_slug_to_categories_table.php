<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug', '255')->nullable()->after('name');
            $table->text('description')->nullable()->after('name');
            $table->boolean('hide_left_column')->default(0)->after('highercategoryid');
            $table->boolean('hide')->default(0)->after('highercategoryid');
            $table->string('impression', '255')->nullable()->after('highercategoryid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('description');
            $table->dropColumn('hide_left_column');
            $table->dropColumn('hide');
            $table->dropColumn('impression');
        });
    }
}
