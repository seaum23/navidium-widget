<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GlobalSetting extends Model
{
    use HasFactory;

    protected $table = 'nvd_global_settings';
    protected $guarded = [];

    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
        );
    }
}
