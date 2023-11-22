<?php

namespace App\Models\Bumps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPagination extends Model
{
    use HasFactory;

    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_product_pagination';
    protected $guarded = [];
}
