<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeVariant extends Model
{
    use HasFactory;

    protected $table = 'nvd_recharge_variants';
    protected $guarded = [];
}
