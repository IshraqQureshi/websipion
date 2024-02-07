<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Websites extends Model
{
    use HasFactory;

    protected $table = "Websites";
    protected $primaryKey = 'websiteID';

    protected $fillable = [
        "ownerID",
        "package_id",
        "domainName",
        "favicon_name",
        "frequency",
        "status",
        "sms_notification",
        "email_cc_recipients",
        "ssl_check",
        "tags",
    ];

    public function GetUser(){
        return $this->belongsTo(User::class, 'ownerID');
    }

    public function crawling()
    {
        return $this->hasMany(CrawlingLog::class, 'websiteID');
    }

}
