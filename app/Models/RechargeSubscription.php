<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeSubscription extends Model
{
    use HasFactory;

    protected $table = 'nvd_recharge_subscriptions';

    public function rechargeSetting(){
        return $this->hasOne(RechargeSetting::class, 'shop_url', 'shop_url');
    }
}
