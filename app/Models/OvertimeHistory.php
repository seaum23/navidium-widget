<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeHistory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "dnp_overtime_histories";
}
