<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','email','password'
    ];

    protected $hidden = [
        'id','password','deleted_at'
    ];

    protected $table = 'nvd_admin';
}
