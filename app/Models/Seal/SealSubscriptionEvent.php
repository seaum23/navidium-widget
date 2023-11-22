<?php

namespace App\Models\Seal;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SealSubscriptionEvent extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "nvd_seal_subscription_events";

    /**
     * Interact with the user's first name.
     */
    protected function payload(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    public function merchant(){
        return $this->belongsTo(Merchant::class, 'shop_url', 'shop_url');
    }

    public function sealSubscription(){
        return $this->belongsTo(SealSubscription::class, 'subscription_id', 'subscription_id');
    }
}
