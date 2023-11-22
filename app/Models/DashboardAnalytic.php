<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardAnalytic extends Model
{
    use HasFactory;
    // public $connection = 'aws';
    
    protected $table = "nvd_dashboard_analytics";
    protected $guarded = [];
}
