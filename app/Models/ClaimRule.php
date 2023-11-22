<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimRule extends Model
{
    use HasFactory;

    protected $table = 'nvd_claim_rules';
    protected $guarded = [];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
