<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtectionSettingHistory extends Model
{
    use HasFactory;

    protected $table = 'nvd_protection_setting_history';
    protected $guarded =[];

    /**
     * Interact with the user's first name.
     */
    protected function protectionData(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }
}
