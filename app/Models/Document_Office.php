<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document_Office extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_id',
        'status',
        'office_code',
    ];

}
