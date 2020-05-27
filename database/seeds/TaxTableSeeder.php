<?php

use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
         * Alberta	GST	0.00%	5.00%	5.00%
         * British Columbia (BC)	GST+PST	7.00%	5.00%	12.00%
         * Manitoba	GST+PST	7.00%	5.00%	12.00%
         * New-Brunswick	HST	10.00%	5.00%	15.00%
         * Newfoundland and Labrador	HST	10.00%	5.00%	15.00%
         * Northwest Territories	GST	0.00%	5.00%	5.00%
         * Nova Scotia	HST	10.00%	5.00%	15.00%
         * Nunavut	GST	0.00%	5.00%	5.00%
         * Ontario	HST	8.00%	5.00%	13.00%
         * Prince Edward Island (PEI)	HST	10.00%	5.00%	15.00%
         * Québec	GST + QST	9.98%	5.00%	14.98%
         * Saskatchewan	GST + PST	6.00%	5.00%	11.00%
         * Yukon	GST	0.00%	5.00%	5.00%

         * */
        DB::table('tax')->delete();
        $vat = [
            ['id' => '1','state_id' => '300','vat_percentage' => '5','state_name' => 'Alberta'],
            ['id' => '2','state_id' => '301','vat_percentage' => '12','state_name' => 'British Columbia'],
            ['id' => '3','state_id' => '302','vat_percentage' => '12','state_name' => 'Manitoba'],
            ['id' => '4','state_id' => '303','vat_percentage' => '15','state_name' => 'New Brunswick'],
            ['id' => '5','state_id' => '304','vat_percentage' => '15','state_name' => 'Newfoundland and Labrador'],
            ['id' => '6','state_id' => '305','vat_percentage' => '5','state_name' => 'Northwest Territories'],
            ['id' => '7','state_id' => '306','vat_percentage' => '15','state_name' => 'Nova Scotia'],
            ['id' => '8','state_id' => '307','vat_percentage' => '13','state_name' => 'Ontario'],
            ['id' => '9','state_id' => '308','vat_percentage' => '15','state_name' => 'Prince Edward Island'],
            ['id' => '10','state_id' => '309','vat_percentage' => '14.98','state_name' => 'Quebec'],
            ['id' => '11','state_id' => '310','vat_percentage' => '11','state_name' => 'Saskatchewan'],
            ['id' => '12','state_id' => '311','vat_percentage' => '5','state_name' => 'Yukon'],
            ['id' => '13','state_id' => '2533','vat_percentage' => '5','state_name' => 'Nunavut'],
        ];
        DB::table('tax')->insert($vat);

    }
}
