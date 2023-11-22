<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAction extends Model
{
    use HasFactory;
    protected $table = 'nvd_ticket_actions';
    protected $guarded = [];
}
