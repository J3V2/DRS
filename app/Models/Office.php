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

    public function documentsReceived() {
        return $this->hasManyThrough(Document::class, User::class, 'office_id', 'received_by');
    }

    public function documentsReceivedCount() {
        return $this->documentsReceived()->count();
    }

    public function documentsReleased() {
        return $this->hasManyThrough(Document::class, User::class, 'office_id', 'released_by');
    }

    public function documentsReleasedCount() {
        return $this->documentsReleased()->count();
    }

    public function documentsTerminal() {
        return $this->hasManyThrough(Document::class, User::class, 'office_id', 'terminal_by');
    }

    public function documentsTerminalCount() {
        return $this->documentsTerminal()->count();
    }

    public function getAverageProcessingTime()
    {
        // Get all users of the office
        $users = $this->users;

        if ($users->isEmpty()) {
            return null; // No users in the office, return null
        }

        $totalSeconds = 0;

        foreach ($users as $user) {
            // Convert AvgProcessTime to seconds
            $totalSeconds += $this->convertToSeconds($user->AvgProcessTime);
        }

        // Calculate average in seconds
        $averageSeconds = $totalSeconds / $users->count();

        // Format the average time
        return $this->formatTimeFromSeconds($averageSeconds);
    }

    protected function convertToSeconds($time)
    {
        // Extract hours from the AvgProcessTime string
        $hours = (float) explode(' ', $time)[0];

        // Determine if it's in hours per day or days per week format
        if (strpos($time, 'hours per day') !== false) {
            return $hours * 3600 * 24; // Convert to seconds per day
        } elseif (strpos($time, 'days per week') !== false) {
            return $hours * 3600 * 24 * 7; // Convert to seconds per week
        } elseif (strpos($time, 'days and') !== false) {
            // Extract days and hours from the AvgProcessTime string
            preg_match('/(\d+) days and (\d+) hours/', $time, $matches);
            $days = (int) $matches[1];
            $hours = (int) $matches[2];
            return ($days * 24 * 3600) + ($hours * 3600); // Convert to seconds
        } else {
            return 0;
        }
    }

    protected function formatTimeFromSeconds($seconds)
    {
        // Calculate days and remaining seconds
        $days = floor($seconds / (3600 * 24));
        $remainingSeconds = $seconds % (3600 * 24);

        // Calculate hours and remaining seconds
        $hours = floor($remainingSeconds / 3600);
        $remainingSeconds %= 3600;

        // Construct the formatted string
        if ($days > 0 && $hours > 0) {
            return "$days days and $hours hours";
        } elseif ($days > 0) {
            return "$days days";
        } elseif ($hours > 0) {
            return "$hours hours";
        } else {
            return "0 hours"; // No processing time
        }
    }
}
