<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
	DB::table('countries')->delete();
	$countries = [
            ['id' => '32','code' => 'CA','name' => 'Canada','phonecode' => '1'],
            ['id' => '202','code' => 'US','name' => 'United States','phonecode' => '1']
		];
		DB::table('countries')->insert($countries);
	}
}
