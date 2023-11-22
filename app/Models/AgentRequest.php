<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRequest extends Model
{
    use HasFactory;
    protected $table = "nvd_install_request_assign";
    protected $guarded = [];
}
