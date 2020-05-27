<?php

use Illuminate\Database\Seeder;
use App\Models\CmsPage;
use Carbon\Carbon;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CmsPage::insert(
            [
                [
                    'page_title'=>'About Us',
                    'page_description'=>'About Us Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'about-us',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Troubleshooting',
                    'page_description'=>'Troubleshooting Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'troubleshooting',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Terms and Conditions',
                    'page_description'=>'Terms and conditions',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'term-condition',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Privacy Policy',
                    'page_description'=>'Privacy Policy Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'privacy',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Grill Tips',
                    'page_description'=>'Grill Tips',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'grill-tips',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Shipping and Returns',
                    'page_description'=>'Shipping And Returns Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'shipping-and-returns',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Sitemap',
                    'page_description'=>'Sitemap Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'sitemap',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'What We Sell',
                    'page_description'=>'What We Sell Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'what-we-sell',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Where and How we ship',
                    'page_description'=>'Where and How We Ship Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'where-and-how-we-ship',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'How to Order',
                    'page_description'=>'How to order Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'how-to-order',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ],
                [
                    'page_title'=>'Care and Maintenance',
                    'page_description'=>'Care and Maintenance Description',
                    'meta_title'=>'',
                    'meta_keyword'=>'',
                    'meta_description'=>'',
                    'slug'=>'care-and-maintenance',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at'=>Carbon::now()
                ]
            ]
        );
    }
}
