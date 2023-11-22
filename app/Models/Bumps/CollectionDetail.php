<?php

namespace App\Models\Bumps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionDetail extends Model
{
    use HasFactory;

    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_collection_details';
    protected $guarded = [];
}
