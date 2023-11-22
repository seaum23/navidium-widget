<?php

namespace App\Models\Bumps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;
    
    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_contents';
    protected $guarded = [];

    protected function contentDetails(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => unserialize($value),
            set: fn ($value) => serialize($value),
        );
    }
}
