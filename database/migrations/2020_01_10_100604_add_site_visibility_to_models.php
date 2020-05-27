<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteVisibilityToModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('models', function (Blueprint $table) {
            $table->boolean('show_on_bbqpartszone_com')->default(1)->nullable()->after('features');
            $table->boolean('show_on_bbqpartsfactory_com')->default(1)->nullable()->after('features');
            $table->boolean('show_on_grillpartsgallery_com')->default(1)->nullable()->after('features');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn('show_on_bbqpartszone_com');
            $table->dropColumn('show_on_bbqpartsfactory_com');
            $table->dropColumn('show_on_grillpartsgallery_com');
        });
    }
}
