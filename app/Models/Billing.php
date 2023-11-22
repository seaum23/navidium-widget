<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'nvd_merchant_billings';
    protected $guarded = [];

    protected $hidden = [
        'id', 'deleted_at', 'deleted'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function appDelete(){
        $this->charge_id = "";
        $this->plan_id = 1;
        $this->charge_approved = 0;
        $this->name = 'Uninstalled';
        $this->price = 0;
        $this->capped_amount = 0;
        $this->deleted_at = now();
        $this->save();
    }
}
