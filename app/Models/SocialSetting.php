<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        "google_client_id",
        "google_client_secret",
        "google_redirect",
        "google_on_off",
        "linkedin_on_off",
        "linkedin_client_id",
        "linkedin_client_secret",
        "linkedin_redirect"
    ];
}
