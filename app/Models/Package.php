<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = "Packages";
    protected $primaryKey = 'id';

    protected $fillable = [
        "packageName",
        "crawlFrequency",
        "type",
        "paymentType",
        "price",
        "webStatus",
    ];

    public function payment()
    {
        return $this->hasMany(PaymentDetails::class, 'packagesID');
    }

}
