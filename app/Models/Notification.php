<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_id',
        'user_triggered_id',
        'type',
        'action',
        'triggered_at',
        'read_at',
        'data',
    ];
}
