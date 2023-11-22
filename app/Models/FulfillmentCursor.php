<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FulfillmentCursor extends Model
{
    use HasFactory;
    protected $table = "fulfillment_cursors";
    protected $guarded = [];
}
