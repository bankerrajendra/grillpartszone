<?php

use Illuminate\Database\Seeder;

class PaymentGatewaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('manage_payment_gateways')->delete();
        $moneris_settings = [
            'live_mode' => 0, // 1 live mode
            'gateway_location_test' => 'https://esqa.moneris.com/HPPDP/index.php',
            'gateway_location_live' => 'https://www3.moneris.com/HPPDP/index.php',
            'transaction_type_id' => 1,
            'post_receipt' => 1,
            'inc_address' => 1,
            'mail_client' => 1,
            'mail_merchant' => "admin@grillpartszone.com",
            'merchants' => [
                'CAD' => [
                    'ps_store_id' => "SD292tore2",
                    'hppkey' => "hpASX1MXBM5B"
                ],
                'USD' => [
                    'ps_store_id' => "3JDXD82593",
                    'hppkey' => "hpU8RFN23KIM"
                ]
            ]
        ];
        $gateway = [
            [
                'id' => 1,
                'name' => 'Paypal',
                'status' => '1',
                'settings' => 'a:7:{s:9:"client_id";s:80:"AVyBTdC50Ins52MgCccQPJ7VE0vvx3PCM3jTFra5RdDRwiafRMQRvZifzN9-9GpYLd0Ij5xqbqLgiA-g";s:10:"secret_key";s:80:"ECYrratltOol1gijWMUVavxCAj1VbBhM8psFfqNRGQ5zNR5qeAuT8MrOh-oKdmEgxdy6pxWAHGPy65VZ";s:4:"mode";s:7:"sandbox";s:18:"connection_timeout";s:2:"30";s:11:"log_enabled";s:4:"true";s:12:"log_filename";s:10:"paypal.log";s:9:"log_level";s:5:"ERROR";}',
                'created_at' => '2020-02-10 13:09:47',
                'updated_at' => '2020-02-10 13:09:47'
            ],
            [
                'id' => 2,
                'name' => 'Moneris',
                'status' => '1',
                'settings' => serialize($moneris_settings),
                'created_at' => '2020-02-24 13:09:47',
                'updated_at' => '2020-02-24 13:09:47'
            ]
        ];
        DB::table('manage_payment_gateways')->insert($gateway);
    }
}
