<?php

namespace App\Models\CarbonShipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonMerchantConfiguration extends Model
{
    use HasFactory;

    protected $table = "nvd_carbon_merchant_configuration";
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function stripeCurrecny(){
        $currency_split = explode('-', $this->currency);
        return $currency_split[1];
    }

    public function carbonMerchantBillings(){
        return $this->hasMany(CarbonMerchantBilling::class, 'merchant_carbon_configuration_id');
    }

    public function pointTransactions(){
        return $this->hasMany(CarbonShippingPointTransaction::class, 'carbon_shipping_detail_id');
    }

    public function carbonPrice(){
        return $this->belongsTo(CarbonPrice::class, 'carbon_price_id');
    }

    public function defaultBilling(){
        return $this->carbonMerchantBillings()->find($this->default_billing_id);
    }
}
