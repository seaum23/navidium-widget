<?php

namespace App\Models\CarbonShipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonShippingPointTransaction extends Model
{
    use HasFactory;

    protected $table = "nvd_carbon_shipping_point_transactions";
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    public function billing(){
        return $this->belongsTo(CarbonMerchantBilling::class, 'carbon_merchant_billing_id');
    }
}
