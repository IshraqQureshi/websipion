<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = "settings";
    protected $primaryKey = 'id';

    protected $fillable = [
        'razorpay_on_off',
        'key_id',
        'key_secret',
        'paypal_on_off',
        'paypal_type',
        'paypal_client_id',
        'paypal_client_secret',
        'stripe_on_off',
        'stripe_client_id',
        'stripe_client_secret',
        'site_up_on_off',
        'site_add_on_off'
    ];
}
