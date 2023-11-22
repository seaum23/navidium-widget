<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'nvd_notices';

    protected $guarded = [];

     /**
     * Get the user's first name.
     */
    protected function notice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => preg_replace("/\r\n|\r|\n/", '<br/>', $value)
        );
    }
}
