<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrrAnalyticsDaily extends Model
{
    use HasFactory;

    protected $table = 'nvd_mrr_analytics_daily';
    protected $guarded = [];
}
