<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsMonthly extends Model
{
    use HasFactory;
    protected $table = "nvd_analytics_monthly";
    protected $guarded = [];

    public function merchant(){
        return $this->hasOne(Merchant::class, 'shop_url', 'shop_url');
    }
}
