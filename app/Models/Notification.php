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
    ],
    $table = 'drs_notifications';

    protected $casts = [
        'data' => 'array',
        'triggered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

}
