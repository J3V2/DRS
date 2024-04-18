<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'title',
        'type',
        'status',
        'action',
        'author',
        'originating_office',
        'current_office',
        'designated_office',
        'file_attach',
        'drive',
        'remarks',
    ];
}
