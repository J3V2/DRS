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
    // Define a many-to-many relationship between documents and offices
    public function designatedOffices()
    {
        return $this->belongsToMany(Office::class, 'document_office', 'document_id', 'office_id');
    }
    public function paperTrails()
    {
        return $this->hasMany(PaperTrail::class);
    }

}
