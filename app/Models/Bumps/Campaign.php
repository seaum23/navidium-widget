<?php

namespace App\Models\Bumps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    
    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_campaigns';
    protected $guarded = [];
}
