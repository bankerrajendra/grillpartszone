<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 23:14:26 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tax
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property float $vat_percentage
 * @property string $state_name
 * @package App\Models
 */

class Shipping extends Model
{
    protected $table = 'shippings';
    //
    public $timestamps = false;

    protected $fillable = [
        'shipping_type',
        'price'
    ];

}
