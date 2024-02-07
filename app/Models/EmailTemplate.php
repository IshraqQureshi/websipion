<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = "emailTemplate";
    protected $primaryKey = 'id';

    protected $fillable = [
        "status_title",
        "title",
        "text",
        "short_text",
    ];
}
