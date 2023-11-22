<?php

namespace App\Models\Bumps;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Segment extends Model
{
    use HasFactory;
    
    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_segments';
    protected $guarded = [];

    protected function conditions(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => @unserialize($value), // suppressing error and sending false if unserialize exception is thrown
            set: fn ($value) => serialize($value),
        );
    }
}
