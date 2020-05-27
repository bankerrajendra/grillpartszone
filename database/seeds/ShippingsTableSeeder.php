<?php

use Illuminate\Database\Seeder;

class ShippingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('shippings')->delete();
        $vat = [
            ['id' => '1','shipping_type' => 'Hawaii','price' => '49.90'],
            ['id' => '2','shipping_type' => 'Alaska','price' => '49.90'],
            ['id' => '3','shipping_type' => 'Expedited','price' => '29.90'],
            ['id' => '4','shipping_type' => 'Free','price' => '0.00'],
            ['id' => '5','shipping_type' => 'MinOrder','price' => '10.00'],

        ];
        DB::table('shippings')->insert($vat);
    }
}
