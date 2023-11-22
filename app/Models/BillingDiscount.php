<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDiscount extends Model
{
    use HasFactory;

    protected $table = 'nvd_special_discounts';
    protected $guarded = [];

    protected $hidden = [
        'id', 'deleted_at','deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
