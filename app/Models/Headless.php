<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headless extends Model
{
    use HasFactory;

    protected $table = 'nvd_headless';
    protected $guarded = [];
}
