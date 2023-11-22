<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    const RESOLVED = 'resolved';
    const DECLINED = 'declined';

    protected $table = 'nvd_claims';
    protected $guarded = [];

    protected $hidden = ['deleted','deleted_at'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function claimAction(){
        return $this->hasOne(ClaimAction::class);
    }

    public function shippingCarriers(){
        return $this->hasMany(ClaimShippingCarrier::class, 'claim_id');
    }
}
