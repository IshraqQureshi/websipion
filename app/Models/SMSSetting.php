<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSSetting extends Model
{
    use HasFactory;
    protected $table = "sms_settings";

    protected $primaryKey = 'id';

    protected $fillable = [
        'key_id',
        'key_secret',
        'twilio_from',
        'twilio_on_off',
    ];
}
