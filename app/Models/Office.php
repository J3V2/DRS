<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * The users that belong to the office.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Define a many-to-many relationship between offices and documents
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_office', 'office_id', 'document_id');
    }
}
