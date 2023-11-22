<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationVaultRecord extends Model
{
    use HasFactory;

    protected $table = 'nvd_installation_vault_records';
    protected $guarded = [];
}
