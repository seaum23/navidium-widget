<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingCronLog extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'nvd_billings_cron_log';
    protected $guarded = [];
}
