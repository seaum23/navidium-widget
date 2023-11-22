<?php

namespace App\Models\Seal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SealSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "nvd_seal_settings";
}
