<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeSetting extends Model
{
    use HasFactory;

    protected $table = 'nvd_recharge_settings';
    protected $guarded = [];

    protected $hidden = [
        'id','deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
