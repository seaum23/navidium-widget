<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'nvd_variants';
    protected $guarded =[];
    protected $hidden =['shop_url'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
