<?php

namespace App\Models;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'nvd_merchants';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function webhooks(){
        return $this->hasMany(Webhook::class, 'shop_url', 'shop_url');
    }

    public function variants(){
        return $this->hasMany(Variant::class, 'shop_url', 'shop_url');
    }

    public function appDelete(){
        $this->access_token = "";
        $this->deleted = 1;
        $this->deleted_at = now();
        $this->save();
    }

    public function billing(){
        return $this->hasOne(Billing::class, 'shop_url', 'shop_url');
    }

    public function products(){
        return $this->hasMany(Product::class, 'shop_url', 'shop_url');
    }

    public function rechargeVariants(){
        return $this->hasMany(RechargeVariant::class, 'shop_url', 'shop_url');
    }

    public function installationVault(){
        return $this->hasOne(InstallationVault::class, 'shop_url', 'shop_url');
    }
}
