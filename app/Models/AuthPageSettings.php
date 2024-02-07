<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthPageSettings extends Model
{
    use HasFactory;
    protected $table = "signup_settings";
    protected $primaryKey = 'id';

    protected $fillable = [
        'signup_on_off',
        'password_on_off',
    ];
}
