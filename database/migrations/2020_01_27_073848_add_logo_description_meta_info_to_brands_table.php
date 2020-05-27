<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoDescriptionMetaInfoToBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->text('meta_description')->nullable()->after('brand');
            $table->text('meta_keywords')->nullable()->after('brand');
            $table->string('meta_title', '1024')->nullable()->after('brand');
            $table->text('description')->nullable()->after('brand');
            $table->string('image')->nullable()->after('brand');
            $table->string('slug', '255')->nullable()->after('brand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('image');
            $table->dropColumn('description');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_description');
        });
    }
}
