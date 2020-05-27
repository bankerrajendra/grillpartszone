<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugImageStatusToModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('models', function (Blueprint $table) {
            $table->string('slug', '255')->nullable()->after('name');
            $table->boolean('status')->default(1)->after('features');
            $table->string('image')->nullable()->after('features');
            $table->bigInteger('old_id')->default(0)->change();
            $table->dropUnique('models_old_id_unique');
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
            $table->dropColumn('slug');
            $table->dropColumn('image');
            $table->dropColumn('status');
        });
    }
}
