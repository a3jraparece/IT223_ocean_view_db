<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriggerLog extends Model
{
    use HasFactory;

    protected $table = 'trigger_logs';

    protected $fillable = [
        'table',
        'action',
        'message',
        'user_id',
    ];  
}
