<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlingLog extends Model
{
    use HasFactory;
    protected $table = "CrawlingLog";
    protected $primaryKey = 'id';

    protected $fillable = [
        "websiteID",
        "crawlTime",
        "status",
    ];

    public function GetDomain(){
        return $this->belongsTo(Websites::class, 'websiteID');
    }



    public function website()
    {
        return $this->belongsTo(Websites::class, 'websiteID');
    }
}
