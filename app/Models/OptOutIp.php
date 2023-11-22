<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptOutIp extends Model
{
    use HasFactory;

    protected $table = 'nvd_optout_ip';
    protected $guarded = [];

}
