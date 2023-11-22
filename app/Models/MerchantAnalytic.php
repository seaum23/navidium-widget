<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantAnalytic extends Model
{
    use HasFactory;
    protected $table = "nvd_merchant_analytics";
    protected $guarded = [];
}
