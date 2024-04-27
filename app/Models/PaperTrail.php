<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'office',
        'action',
        'remarks',
        'file_attach',
        'drive',
        'in_time',
        'out_time',
        'elapsed_time',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
