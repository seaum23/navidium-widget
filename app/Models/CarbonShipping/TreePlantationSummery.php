<?php

namespace App\Models\CarbonShipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreePlantationSummery extends Model
{
    use HasFactory;

    protected $table = "tree_plantations_summeries";
    protected $guarded = [];
    
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
