<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDiscount extends Model
{
    use HasFactory;

    protected $table = 'nvd_special_discounts';

    protected $guarded = [];
    protected $hidden = [
        'deleted',
        'deleted_at'
    ];
}
