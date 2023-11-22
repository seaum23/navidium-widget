<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrrHistory extends Model
{
    use HasFactory;

    protected $table = 'nvd_mrr_histories';
    protected $guarded = [];

    public $timestamps = false;
}
