<?php

namespace App\Models\Seal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SealSubscription extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "nvd_seal_subscriptions";

    public function sealSetting(){
        return $this->belongsTo(SealSetting::class, 'shop_url', 'shop_url');
    }
}
