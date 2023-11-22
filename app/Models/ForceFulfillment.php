<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForceFulfillment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "dnp_force_fulfillments";
}
