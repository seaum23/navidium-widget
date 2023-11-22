<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAssignee extends Model
{
    use HasFactory;
    protected $table = 'nvd_ticket_assignee';
    protected $guarded = [];
}
