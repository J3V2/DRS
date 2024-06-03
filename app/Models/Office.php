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

        // Determine if it's in hours per day, days per week, or months per year format
        if (strpos($time, 'hours per day') !== false) {
            return $hours * 3600 * 24; // Convert to seconds per day
        } elseif (strpos($time, 'days per week') !== false) {
            return $hours * 3600 * 24 * 7; // Convert to seconds per week
        } elseif (strpos($time, 'months per year') !== false) {
            return $hours * 3600 * 24 * 30 * 12; // Convert to seconds per year
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
        // Calculate years and remaining seconds
        $years = floor($seconds / (3600 * 24 * 30 * 12));
        $remainingSeconds = $seconds % (3600 * 24 * 30 * 12);

        // Calculate months, days, hours and remaining seconds
        $months = floor($remainingSeconds / (3600 * 24 * 30));
        $remainingSeconds %= (3600 * 24 * 30);
        $days = floor($remainingSeconds / (3600 * 24));
        $remainingSeconds %= (3600 * 24);
        $hours = floor($remainingSeconds / 3600);

        // Construct the formatted string
        $formattedString = '';
        if ($years > 0) {
            $formattedString .= "$years years ";
        }
        if ($months > 0) {
            $formattedString .= "$months months ";
        }
        if ($days > 0) {
            $formattedString .= "$days days ";
        }
        if ($hours > 0) {
            $formattedString .= "$hours hours";
        }

        return trim($formattedString);
    }
}
