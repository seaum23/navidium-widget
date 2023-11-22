<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplateSetting extends Model
{
    use HasFactory;

    protected $table = 'nvd_email_template_settings';
    protected $guarded = [];
}
