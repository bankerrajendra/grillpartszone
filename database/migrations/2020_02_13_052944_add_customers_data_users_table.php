<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomersDataUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(0)->after('password');
            $table->integer('old_customer_id')->nullable()->after('password');
            $table->string('old_user_name', '100')->nullable()->after('password');
            $table->integer('country_id')->unsigned()->nullable()->after('password');
            $table->integer('state_id')->unsigned()->nullable()->after('password');
            $table->integer('city_id')->unsigned()->nullable()->after('password');
            $table->char('zip',20)->nullable()->after('password');
            $table->string('address_2', 255)->nullable()->after('password');
            $table->string('address_1', 255)->nullable()->after('password');
            $table->char('mobile_number',191)->nullable()->after('password');
            $table->string('company', 255)->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('old_customer_id');
            $table->dropColumn('old_user_name');
            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
            $table->dropColumn('city_id');
            $table->dropColumn('zip');
            $table->dropColumn('address_2');
            $table->dropColumn('address_1');
            $table->dropColumn('mobile_number');
            $table->dropColumn('company');
            $table->dropColumn('name');
        });
    }
}
