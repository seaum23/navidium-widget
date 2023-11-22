<?php

namespace App\Models\CarbonShipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonMerchantBilling extends Model
{
    use HasFactory;

    protected $table = "nvd_carbon_merchant_billings";
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
