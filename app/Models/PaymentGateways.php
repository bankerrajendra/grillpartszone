<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateways extends Model
{
    protected $table = 'manage_payment_gateways';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'status',
        'settings'
    ];
}
