<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetafieldDefault extends Model
{
    use HasFactory;

    protected $table = 'nvd_meta_defaults';
    protected $guarded = [];

    protected $hidden = [
        'id','created_at','updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
