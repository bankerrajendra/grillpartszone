<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Brands
         *
         */
        $BrandsItems = [
            [
                'chr' => 'A',
                'brand' => 'ACADEMY SPORTS'
            ],
            [
                'chr' => 'A',
                'brand' => 'Alfresco'
            ],
            [
                'chr' => 'A',
                'brand' => 'Altima'
            ],
            [
                'chr' => 'A',
                'brand' => 'Amana'
            ],
            [
                'chr' => 'A',
                'brand' => 'American Outdoor Grill'
            ],
            [
                'chr' => 'A',
                'brand' => 'ARKLA'
            ],
            [
                'chr' => 'A',
                'brand' => 'Aussie'
            ],
            [
                'chr' => 'A',
                'brand' => 'AUSTRALIAN BARBECUE'
            ],
            [
                'chr' => 'B',
                'brand' => 'BACKYARD CLASSIC'
            ],
            [
                'chr' => 'B',
                'brand' => 'BAKERS AND CHEFS'
            ],
            [
                'chr' => 'B',
                'brand' => 'Barbeques Galore'
            ],
            [
                'chr' => 'B',
                'brand' => 'BBQ grillware '
            ],
            [
                'chr' => 'B',
                'brand' => 'BBQ-PRO'
            ],
            [
                'chr' => 'B',
                'brand' => 'BBQTEK'
            ],
            [
                'chr' => 'B',
                'brand' => 'BEEFEATER'
            ],
            [
                'chr' => 'B',
                'brand' => 'BHG'
            ],
            [
                'chr' => 'B',
                'brand' => 'BIG GREEN EGG'
            ],
            [
                'chr' => 'B',
                'brand' => 'BLAZE'
            ],
            [
                'chr' => 'B',
                'brand' => 'BLOOMA'
            ],
            [
                'chr' => 'B',
                'brand' => 'BOND'
            ],
            [
                'chr' => 'B',
                'brand' => 'BRINKMANN'
            ],
            [
                'chr' => 'B',
                'brand' => 'BROIL CHEF'
            ],
            [
                'chr' => 'B',
                'brand' => 'BROIL IMPERIAL'
            ],
            [
                'chr' => 'B',
                'brand' => 'BROIL KING'
            ],
            [
                'chr' => 'B',
                'brand' => 'BROIL-MATE'
            ],
            [
                'chr' => 'B',
                'brand' => 'BROILCHEF'
            ],
            [
                'chr' => 'B',
                'brand' => 'BULL'
            ],
            [
                'chr' => 'C',
                'brand' => 'CALPHALON'
            ],
            [
                'chr' => 'C',
                'brand' => 'CAPTN COOK'
            ],
            [
                'chr' => 'C',
                'brand' => 'CENTRO'
            ],
            [
                'chr' => 'C',
                'brand' => 'CFM'
            ],
            [
                'chr' => 'C',
                'brand' => 'CHARBROIL'
            ],
            [
                'chr' => 'C',
                'brand' => 'CHARGRILLER'
            ],
            [
                'chr' => 'C',
                'brand' => 'CHARMGLOW'
            ],
            [
                'chr' => 'C',
                'brand' => 'COASTAL'
            ],
            [
                'chr' => 'C',
                'brand' => 'COLEMAN'
            ],
            [
                'chr' => 'C',
                'brand' => 'COOK ON'
            ],
            [
                'chr' => 'C',
                'brand' => 'COSTCO'
            ],
            [
                'chr' => 'C',
                'brand' => 'CUISINART'
            ],
            [
                'chr' => 'D',
                'brand' => 'DCS'
            ],
            [
                'chr' => 'D',
                'brand' => 'DUCANE'
            ],
            [
                'chr' => 'D',
                'brand' => 'DURO'
            ],
            [
                'chr' => 'D',
                'brand' => 'DYNA-GLO'
            ],
            [
                'chr' => 'E',
                'brand' => 'EL PATIO'
            ],
            [
                'chr' => 'E',
                'brand' => 'ELECTROLUX'
            ],
            [
                'chr' => 'E',
                'brand' => 'ELLIPSE'
            ],
            [
                'chr' => 'E',
                'brand' => 'EMBERMATIC'
            ],
            [
                'chr' => 'E',
                'brand' => 'EMERIL'
            ],
            [
                'chr' => 'E',
                'brand' => 'EVERYDAY ESSENTIALS'
            ],
            [
                'chr' => 'F',
                'brand' => 'FALCON'
            ],
            [
                'chr' => 'F',
                'brand' => 'FIESTA'
            ],
            [
                'chr' => 'F',
                'brand' => 'FRIGIDAIRE'
            ],
            [
                'chr' => 'F',
                'brand' => 'FRONT AVENUE'
            ],
            [
                'chr' => 'F',
                'brand' => 'FRONTGATE'
            ],
            [
                'chr' => 'G',
                'brand' => 'GE'
            ],
            [
                'chr' => 'G',
                'brand' => 'GENESIS'
            ],
            [
                'chr' => 'G',
                'brand' => 'GLEN CANYON'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRAND CAFE'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRAND GOURMET'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRAND HALL'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRAND ISLE'
            ],
            [
                'chr' => 'G',
                'brand' => 'GREAT OUTDOORS'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILL CHEF'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILL KING'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILL ZONE'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILLADA'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILLMASTER'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILLMATE'
            ],
            [
                'chr' => 'G',
                'brand' => 'GRILLPRO'
            ],
            [
                'chr' => 'H',
                'brand' => 'HAMILTON BEACH'
            ],
            [
                'chr' => 'H',
                'brand' => 'HARRIS TEETER'
            ],
            [
                'chr' => 'H',
                'brand' => 'HOME DEPOT'
            ],
            [
                'chr' => 'H',
                'brand' => 'HUNTINGTON'
            ],
            [
                'chr' => 'I',
                'brand' => 'IGLOO'
            ],
            [
                'chr' => 'I',
                'brand' => 'IGS'
            ],
            [
                'chr' => 'J',
                'brand' => 'JENN-AIR'
            ],
            [
                'chr' => 'K',
                'brand' => 'KALAMAZOO'
            ],
            [
                'chr' => 'K',
                'brand' => 'KENMORE'
            ],
            [
                'chr' => 'K',
                'brand' => 'KING GRILLER'
            ],
            [
                'chr' => 'K',
                'brand' => 'KIRKLAND'
            ],
            [
                'chr' => 'K',
                'brand' => 'KITCHENAID'
            ],
            [
                'chr' => 'K',
                'brand' => 'KMART'
            ],
            [
                'chr' => 'L',
                'brand' => 'LAZY MAN'
            ],
            [
                'chr' => 'L',
                'brand' => 'LIFE@HOME'
            ],
            [
                'chr' => 'L',
                'brand' => 'LYNX'
            ],
            [
                'chr' => 'M',
                'brand' => 'MARTHA STEWART'
            ],
            [
                'chr' => 'M',
                'brand' => 'MASTER CHEF'
            ],
            [
                'chr' => 'M',
                'brand' => 'MASTER COOK'
            ],
            [
                'chr' => 'M',
                'brand' => 'MASTER FORGE '
            ],
            [
                'chr' => 'M',
                'brand' => 'MASTERBUILT'
            ],
            [
                'chr' => 'M',
                'brand' => 'MAXFIRE'
            ],
            [
                'chr' => 'M',
                'brand' => 'MEDALLION'
            ],
            [
                'chr' => 'M',
                'brand' => 'MEMBERS MARK'
            ],
            [
                'chr' => 'M',
                'brand' => 'MHP'
            ],
            [
                'chr' => 'M',
                'brand' => 'MINTCRAFT'
            ],
            [
                'chr' => 'N',
                'brand' => 'NAPOLEON'
            ],
            [
                'chr' => 'N',
                'brand' => 'NEXGRILL'
            ],
            [
                'chr' => 'N',
                'brand' => 'NORTH AMERICAN OUTDOORS'
            ],
            [
                'chr' => 'O',
                'brand' => 'OLYMPIA'
            ],
            [
                'chr' => 'O',
                'brand' => 'OMAHA'
            ],
            [
                'chr' => 'O',
                'brand' => 'ONWARD'
            ],
            [
                'chr' => 'O',
                'brand' => 'OUTBACK'
            ],
            [
                'chr' => 'O',
                'brand' => 'OUTDOOR GOURMET'
            ],
            [
                'chr' => 'P',
                'brand' => 'PATIO CHEF'
            ],
            [
                'chr' => 'P',
                'brand' => 'PATIO RANGE'
            ],
            [
                'chr' => 'P',
                'brand' => 'PATIOKITCHEN'
            ],
            [
                'chr' => 'P',
                'brand' => 'PERFECT FLAME'
            ],
            [
                'chr' => 'P',
                'brand' => 'PERFECTGLO'
            ],
            [
                'chr' => 'P',
                'brand' => 'PERMASTEEL'
            ],
            [
                'chr' => 'P',
                'brand' => 'PGS'
            ],
            [
                'chr' => 'P',
                'brand' => 'PHOENIX'
            ],
            [
                'chr' => 'P',
                'brand' => 'PREMIER'
            ],
            [
                'chr' => 'P',
                'brand' => 'PRESIDENTS CHOICE'
            ],
            [
                'chr' => 'P',
                'brand' => 'PRO SERIES'
            ],
            [
                'chr' => 'P',
                'brand' => 'PROCHEF'
            ],
            [
                'chr' => 'S',
                'brand' => 'SAMS'
            ],
            [
                'chr' => 'S',
                'brand' => 'SATURN'
            ],
            [
                'chr' => 'S',
                'brand' => 'SAVOR PRO'
            ],
            [
                'chr' => 'S',
                'brand' => 'SHINERICH'
            ],
            [
                'chr' => 'S',
                'brand' => 'SILVER CHEF'
            ],
            [
                'chr' => 'S',
                'brand' => 'SMOKE CANYON'
            ],
            [
                'chr' => 'S',
                'brand' => 'SMOKE HOLLOW'
            ],
            [
                'chr' => 'S',
                'brand' => 'SONOMA'
            ],
            [
                'chr' => 'S',
                'brand' => 'STERLING'
            ],
            [
                'chr' => 'S',
                'brand' => 'STERLING FORGE'
            ],
            [
                'chr' => 'S',
                'brand' => 'STERLING SHEPHERD'
            ],
            [
                'chr' => 'S',
                'brand' => 'STRADA'
            ],
            [
                'chr' => 'S',
                'brand' => 'SUNBEAM'
            ],
            [
                'chr' => 'S',
                'brand' => 'SUNSHINE'
            ],
            [
                'chr' => 'S',
                'brand' => 'SUREFIRE'
            ],
            [
                'chr' => 'S',
                'brand' => 'SUREHEAT'
            ],
            [
                'chr' => 'T',
                'brand' => 'TERA GEAR'
            ],
            [
                'chr' => 'T',
                'brand' => 'TETON'
            ],
            [
                'chr' => 'T',
                'brand' => 'THERMOS'
            ],
            [
                'chr' => 'T',
                'brand' => 'TURBO'
            ],
            [
                'chr' => 'T',
                'brand' => 'TURCO'
            ],
            [
                'chr' => 'T',
                'brand' => 'TUSCANY'
            ],
            [
                'chr' => 'U',
                'brand' => 'UBERHAUS'
            ],
            [
                'chr' => 'U',
                'brand' => 'UNIFLAME'
            ],
            [
                'chr' => 'V',
                'brand' => 'VERMONT CASTING'
            ],
            [
                'chr' => 'V',
                'brand' => 'VIRCO'
            ],
            [
                'chr' => 'V',
                'brand' => 'VISION'
            ],
            [
                'chr' => 'W',
                'brand' => 'WEBER'
            ],
            [
                'chr' => 'X',
                'brand' => 'XPS'
            ],
        ];

        /*
         * Add Brand Items
         *
         */
        foreach ($BrandsItems as $Item) {
            $newBrandItem = Brand::where('brand', '=', $Item['brand'])->first();
            if ($newBrandItem === null) {
                $newBrandItem = Brand::create([
                    'chr'          => $Item['chr'],
                    'brand'        => $Item['brand']
                ]);
            }
        }
    }
}
