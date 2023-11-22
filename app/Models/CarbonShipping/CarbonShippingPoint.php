<?php

namespace App\Models\CarbonShipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonShippingPoint extends Model
{
    use HasFactory;

    protected $table = "nvd_carbon_shipping_points";
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
