<?php

use Illuminate\Database\Seeder;

use App\Models\State;
use App\Models\City;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        City::truncate();
        State::truncate();
        Schema::enableForeignKeyConstraints();
        $states = [
            ['id' => '300', 'name' => 'Alberta', 'country_id' => '32'],
            ['id' => '301', 'name' => 'British Columbia', 'country_id' => '32'],
            ['id' => '302', 'name' => 'Manitoba', 'country_id' => '32'],
            ['id' => '303', 'name' => 'New Brunswick', 'country_id' => '32'],
            ['id' => '304', 'name' => 'Newfoundland and Labrador', 'country_id' => '32'],
            ['id' => '305', 'name' => 'Northwest Territories', 'country_id' => '32'],
            ['id' => '306', 'name' => 'Nova Scotia', 'country_id' => '32'],
            ['id' => '307', 'name' => 'Ontario', 'country_id' => '32'],
            ['id' => '308', 'name' => 'Prince Edward Island', 'country_id' => '32'],
            ['id' => '309', 'name' => 'Quebec', 'country_id' => '32'],
            ['id' => '310', 'name' => 'Saskatchewan', 'country_id' => '32'],
            ['id' => '311', 'name' => 'Yukon', 'country_id' => '32'],
            ['id' => '2316', 'name' => 'Alabama', 'country_id' => '202'],
            ['id' => '2317', 'name' => 'Alaska', 'country_id' => '202'],
            ['id' => '2318', 'name' => 'Arizona', 'country_id' => '202'],
            ['id' => '2319', 'name' => 'Arkansas', 'country_id' => '202'],
            ['id' => '2320', 'name' => 'California', 'country_id' => '202'],
            ['id' => '2321', 'name' => 'Colorado', 'country_id' => '202'],
            ['id' => '2322', 'name' => 'Connecticut', 'country_id' => '202'],
            ['id' => '2323', 'name' => 'Delaware', 'country_id' => '202'],
            ['id' => '2324', 'name' => 'Florida', 'country_id' => '202'],
            ['id' => '2325', 'name' => 'Georgia', 'country_id' => '202'],
            ['id' => '2326', 'name' => 'Hawaii', 'country_id' => '202'],
            ['id' => '2327', 'name' => 'Idaho', 'country_id' => '202'],
            ['id' => '2328', 'name' => 'Illinois', 'country_id' => '202'],
            ['id' => '2329', 'name' => 'Indiana', 'country_id' => '202'],
            ['id' => '2330', 'name' => 'Iowa', 'country_id' => '202'],
            ['id' => '2331', 'name' => 'Kansas', 'country_id' => '202'],
            ['id' => '2332', 'name' => 'Kentucky', 'country_id' => '202'],
            ['id' => '2333', 'name' => 'Louisiana', 'country_id' => '202'],
            ['id' => '2334', 'name' => 'Maine', 'country_id' => '202'],
            ['id' => '2335', 'name' => 'Maryland', 'country_id' => '202'],
            ['id' => '2336', 'name' => 'Massachusetts', 'country_id' => '202'],
            ['id' => '2337', 'name' => 'Michigan', 'country_id' => '202'],
            ['id' => '2338', 'name' => 'Minnesota', 'country_id' => '202'],
            ['id' => '2339', 'name' => 'Mississippi', 'country_id' => '202'],
            ['id' => '2340', 'name' => 'Missouri', 'country_id' => '202'],
            ['id' => '2341', 'name' => 'Montana', 'country_id' => '202'],
            ['id' => '2342', 'name' => 'Nebraska', 'country_id' => '202'],
            ['id' => '2343', 'name' => 'Nevada', 'country_id' => '202'],
            ['id' => '2344', 'name' => 'New Hampshire', 'country_id' => '202'],
            ['id' => '2345', 'name' => 'New Jersey', 'country_id' => '202'],
            ['id' => '2346', 'name' => 'New Mexico', 'country_id' => '202'],
            ['id' => '2347', 'name' => 'New York', 'country_id' => '202'],
            ['id' => '2348', 'name' => 'North Carolina', 'country_id' => '202'],
            ['id' => '2349', 'name' => 'North Dakota', 'country_id' => '202'],
            ['id' => '2350', 'name' => 'Ohio', 'country_id' => '202'],
            ['id' => '2351', 'name' => 'Oklahoma', 'country_id' => '202'],
            ['id' => '2352', 'name' => 'Oregon', 'country_id' => '202'],
            ['id' => '2353', 'name' => 'Pennsylvania', 'country_id' => '202'],
            ['id' => '2354', 'name' => 'Rhode Island', 'country_id' => '202'],
            ['id' => '2355', 'name' => 'South Carolina', 'country_id' => '202'],
            ['id' => '2356', 'name' => 'South Dakota', 'country_id' => '202'],
            ['id' => '2357', 'name' => 'Tennessee', 'country_id' => '202'],
            ['id' => '2358', 'name' => 'Texas', 'country_id' => '202'],
            ['id' => '2359', 'name' => 'Utah', 'country_id' => '202'],
            ['id' => '2360', 'name' => 'Vermont', 'country_id' => '202'],
            ['id' => '2361', 'name' => 'Virginia', 'country_id' => '202'],
            ['id' => '2362', 'name' => 'Washington', 'country_id' => '202'],
            ['id' => '2363', 'name' => 'West Virginia', 'country_id' => '202'],
            ['id' => '2364', 'name' => 'Wisconsin', 'country_id' => '202'],
            ['id' => '2365', 'name' => 'Wyoming', 'country_id' => '202'],
            ['id' => '2533', 'name' => 'Nunavut', 'country_id' => '32'],
        ];

        DB::table('states')->insert($states);
    }
}
