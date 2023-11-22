<?php

namespace App\Models\Bumps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsMonthly extends Model
{
    use HasFactory;

    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_analytics_daily';
    protected $guarded = [];
}
