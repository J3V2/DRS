<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

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
        'received_by',
        'released_by',
        'terminal_by',
    ],
    $table = 'drs_documents';

    public function designatedOffice()
    {
        return $this->belongsTo(Office::class, 'designated_office');
    }

    public function paperTrails() {
        return $this->hasMany(PaperTrail::class);
    }

    public function receivedBy() {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function releasedBy() {
        return $this->belongsTo(User::class, 'released_by');
    }

    public function terminalBy() {
        return $this->belongsTo(User::class, 'terminal_by');
    }
}
