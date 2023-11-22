<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "dnp_salary_histories";
    const PAGINATE_LENGTH = 10;
}
