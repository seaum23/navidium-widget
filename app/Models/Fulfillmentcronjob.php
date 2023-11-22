<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fulfillmentcronjob extends Model
{
    use HasFactory;
    protected $table = "dnp_fulfillment_cronjobs";
    protected $guarded = [];
}
