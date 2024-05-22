<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Chatify\Traits\UUID;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use UUID, InteractsWithMedia;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'FirstLogin',
        'LastLogin',
        'AvgProcessTime',
        'office_id',
        'current_login_at',
        'last_logout_at',
        'sessions_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'FirstLogin' => 'datetime',
        'LastLogin' => 'datetime',
        'current_login_at' => 'datetime',
        'last_logout_at' => 'datetime',
    ];

    static public function getEmailSingle($email) {
        return self::where('email','=',$email)->firstOrFail();
    }

    static public function getTokenSingle($remember_token){
        return self::where('remember_token','=',$remember_token)->firstOrFail();
    }

    public function documentsReceived() {
        return $this->hasMany(Document::class, 'received_by');
    }

    public function documentsReceivedCount() {
        return $this->documentsReceived()->count();
    }

    public function documentsReleased() {
        return $this->hasMany(Document::class, 'released_by');
    }

    public function documentsReleasedCount() {
        return $this->documentsReleased()->count();
    }

    public function documentsTerminal() {
        return $this->hasMany(Document::class, 'terminal_by');
    }

    public function documentsTerminalCount() {
        return $this->documentsTerminal()->count();
    }

    public function office() {
        return $this->belongsTo(Office::class);
    }

}
