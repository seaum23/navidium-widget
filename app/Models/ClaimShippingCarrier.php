<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimShippingCarrier extends Model
{
    use HasFactory;

    protected $table = 'nvd_claim_shipping_carrier';
    protected $guarded = [];
    public $timestamps = false;
}
