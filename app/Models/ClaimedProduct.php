<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClaimedProduct extends Model
{
    use HasFactory;

    protected $table = 'nvd_claimed_product';
    protected $guarded = [];

    protected $hidden = ['id', 'shop_url', 'claim_id', 'order_id', 'claim_issue','status','deleted','deleted_at','created_at','updated_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Interact with the user's first name.
     */
    protected function variantDetails(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }
}
