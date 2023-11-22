<?php

namespace App\Models\Skio;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkioSubscription extends Model
{
    use HasFactory;

    protected $table = 'nvd_skio_subscriptions';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'subscription_url'
    ];

    public function getSubscriptionUrlAttribute()
    {
        return "https://dashboard.skio.com/subscriptions/{$this->subscription_id}";
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class, 'shop_url', 'shop_url');
    }

    public function setting(){
        return $this->belongsTo(SkioSetting::class, 'shop_url', 'shop_url');
    }

    public function subscriptionDetails(){
        return $this->hasMany(SkioSubscriptionDetail::class, 'nvd_skio_subscription_id');
    }
}
