<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeAnalyticsMonthly extends Model
{
    use HasFactory;

    protected $table = 'nvd_recharge_analytics_monthly';
    protected $guarded = [];
}
