<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlDeleteScheduling extends Model
{
    use HasFactory;
    protected $table = "crawl_log_delete_scheduling";
    protected $primaryKey = 'id';

    protected $fillable = [
        "user_id",
        "delete_type",
    ];

    public function GetUserInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
