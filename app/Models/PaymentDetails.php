<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;
    protected $table = "PaymentDetails";
    protected $primaryKey = 'id';

    protected $fillable = [
        "userID",
        "packagesID",
        "totalWebsite",
        "invoiceNumber",
        "transactionID",
        "subscriptionID",
        "paymentMode",
        "totalPayment",
        "transactionTime",
        "expiryDate",
    ];

    public function GetUser(){
        return $this->belongsTo(User::class, 'userID');
    }

    public function Getpackage(){
        return $this->belongsTo(Package::class, 'packagesID');
    }
}
