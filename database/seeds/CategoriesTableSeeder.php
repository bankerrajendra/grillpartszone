<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Add categories
         */
        $categoriesItems = [
            [
                'id' => '22',
                'name' => 'Barbecues Accessories',
                'highercategoryid' => '0',
                'hassubcategory' => 'Y',
                'meta_title' => 'BBQ Accessories & Grilling Tools at Grill Parts Gallery USA & Canada',
                'meta_keywords' => 'Grilling Accessories, BBQ Accessories, Grilling Tools, Rotisserie Kits, Smoker Boxes, BBQ Tools, BBQ Spices, BBQ Aprons, BBQ Gloves, Grilling Skewers, BBQ Covers, BBQ Toppers, Charcoal Chimney Starter, Lump Charcoal, BBQ Thermometers.',
                'meta_description' => 'We offers top quality BBQ accessories and grilling tools/accessories at reasonable prices. Everthing from Rotisserie Kits to Smoker boxes to Wood chips.','Find a wide selection of reliable BBQ accessories, at reasonable prices to to enhance and improve your grilling experience.',
                'ordernum' => '2'
            ],
            [
                'id' => '27',
                'name' => 'Care and Maintenance',
                'highercategoryid' => '0',
                'hassubcategory' => 'Y',
                'meta_title' => 'Planks, BBQ Accessory, BBQ, BBQ Grills',
                'meta_keywords' => 'bbq accessory, barbeque, bbq, bbq grills, barbecue, replacement parts, grill parts, bbq islands, fire pits, fire places, smokers, kamado, egg bbq, propane patio heaters, natural gas grills, propane barbeque, portable grill, patio furniture, torches, outdoor kitchens,planks, bbq accessory, barbeque, bbq, bbq grills, barbecue, replacement parts','Plank is used to make fish grilling easier, better and tastier. This process is one of the best ways to cook fish, whether whole, fillets, or steaks. The wood plank, usually cedar, provides a platform to hold the fish together.',
                'meta_description' => 'bbq accessory, barbeque, bbq, bbq grills, barbecue, replacement parts, grill parts, bbq islands, fire pits, fire places, smokers, kamado, egg bbq, propane patio heaters, natural gas grills, propane barbeque, portable grill, patio furniture, torches, outdoor kitchens,planks, bbq accessory, barbeque, bbq, bbq grills, barbecue, replacement parts','Plank is used to make fish grilling easier, better and tastier. This process is one of the best ways to cook fish, whether whole, fillets, or steaks. The wood plank, usually cedar, provides a platform to hold the fish together.',
                'ordernum' => '6'
            ],
            [
                'id' => '15',
                'name' => 'Universal Grill',
                'highercategoryid' => '0',
                'hassubcategory' => 'Y',
                'meta_title' => 'Gas Grill Replacement parts from Weber, Broil King, Thermos, Charbroil Models, Costco Kirkland, Kenmore Sears, Master Chef, Brinkmann, Ducane, Nexgrill, Virco, Members Mark, PerfECT Flame and others.',
                'meta_keywords' => 'Gas Grill Replacement parts from Weber, Broil King, Thermos, Charbroil Models, Costco Kirkland, Kenmore Sears, Master Chef, Brinkmann, Ducane, Nexgrill, Virco, Members Mark, PerfECT Flame and others.',
                'meta_description' => 'Gas Grill Replacement parts from Weber, Broil King, Thermos, Charbroil Models, Costco Kirkland, Kenmore Sears, Master Chef, Brinkmann, Ducane, Nexgrill, Virco, Members Mark, PerfECT Flame and others.',
                'ordernum' => '5'
            ],
            [
                'id' => '19',
                'name' => 'Grill Parts',
                'highercategoryid' => '0',
                'hassubcategory' => 'N',
                'meta_title' => 'BBQ and Gas Grill Parts that fit your gas grills. Find universal genuine replacement repair parts for gas grills & charcoal grills.',
                'meta_keywords' => 'BBQ and Gas Grill Parts that fit your gas grills. Find universal genuine replacement repair parts for gas grills & charcoal grills.',
                'meta_description' => 'BBQ and Gas Grill Parts that fit your gas grills. Find universal genuine replacement repair parts for gas grills & charcoal grills.',
                'ordernum' => '0'
            ],
            [
                'id' => '25',
                'name' => 'BBQ Thermometers',
                'highercategoryid' => '22',
                'hassubcategory' => 'N',
                'meta_title' => 'BBQ Thermometers| Grill Accessories & Grilling Tools | Digital Meat Thermometer',
                'meta_keywords' => 'BBQ Thermometers| Grill Accessories & Grilling Tools | Digital Meat Thermometer',
                'meta_description' => 'BBQ Thermometers| Grill Accessories & Grilling Tools | Digital Meat Thermometer',
                'ordernum' => '20'
            ],
            [
                'id' => '44',
                'name' => 'Grill Covers',
                'highercategoryid' => '22',
                'hassubcategory' => 'N',
                'meta_title' => 'Protect Your Grill With A Good Quality Grill Cover | Grill Parts Gallery USA & Canada',
                'meta_keywords' => 'Protect Your Grill With A Good Quality Grill Cover | Grill Parts Gallery USA & Canada',
                'meta_description' => 'Protect Your Grill With A Good Quality Grill Cover | Grill Parts Gallery USA & Canada',
                'ordernum' => '0'
            ],
            [
                'id' => '84',
                'name' => 'Grilling Tools',
                'highercategoryid' => '22',
                'hassubcategory' => 'N',
                'meta_title' => 'Shop Low Prices On Grilling Tools & BBQ Utensils | Grilling Tools & BBQ Grill Tools at GrillPartsGallery USA & Canada',
                'meta_keywords' => 'Shop Low Prices On Grilling Tools & BBQ Utensils | Grilling Tools & BBQ Grill Tools at GrillPartsGallery USA & Canada',
                'meta_description' => 'Shop Low Prices On Grilling Tools & BBQ Utensils | Grilling Tools & BBQ Grill Tools at GrillPartsGallery USA & Canada',
                'ordernum' => '0'
            ],
            [
                'id' => '85',
                'name' => 'Barbeque Grill Light',
                'highercategoryid' => '22',
                'hassubcategory' => 'N',
                'meta_title' => 'Barbecue Lights, Grill Lights, Grill Covers, and More - GrillPartsGallery',
                'meta_keywords' => 'Barbecue Lights, Grill Lights, Grill Covers, and More - GrillPartsGallery',
                'meta_description' => 'Barbecue Lights, Grill Lights, Grill Covers, and More - GrillPartsGallery',
                'ordernum' => '0'
            ],
            [
                'id' => '86',
                'name' => 'Grill Brush',
                'highercategoryid' => '22',
                'hassubcategory' => 'N',
                'meta_title' => 'Barbecue Grill Brushes, Grilling Accessories, BBQ Tool Set by GrillPartsGallery.com',
                'meta_keywords' => 'Barbecue Grill Brushes, Grilling Accessories, BBQ Tool Set by GrillPartsGallery.com',
                'meta_description' => 'Barbecue Grill Brushes, Grilling Accessories, BBQ Tool Set by GrillPartsGallery.com',
                'ordernum' => '0'
            ],
            [
                'id' => '87',
                'name' => 'Special Offers',
                'highercategoryid' => '0',
                'hassubcategory' => 'N',
                'meta_title' => 'BBQ Grill Parts, Grilling Accessories | Many Replacement Grill Parts Reduced',
                'meta_keywords' => 'BBQ Grill Parts, Grilling Accessories | Many Replacement Grill Parts Reduced',
                'meta_description' => 'BBQ Grill Parts, Grilling Accessories | Many Replacement Grill Parts Reduced',
                'ordernum' => '0'
            ]
        ];

        /*
         * Add Items
         *
         */
        foreach ($categoriesItems as $Item) {
            $newItem = Category::where('id', '=', $Item['id'])->first();
            if ($newItem === null) {
                $newItem = Category::create([
                    'id' => $Item['id'],
                    'name' => $Item['name'],
                    'highercategoryid' => $Item['highercategoryid'],
                    'hassubcategory' => $Item['hassubcategory'],
                    'meta_title' => $Item['meta_title'],
                    'meta_keywords' => $Item['meta_keywords'],
                    'meta_description' => $Item['meta_description'],
                    'ordernum' => $Item['ordernum']
                ]);
            }
        }
    }
}
