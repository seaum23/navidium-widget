<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'dnp_employees';
    protected $guarded = [];

    const PAGINATE_LENGTH = 10;
}
