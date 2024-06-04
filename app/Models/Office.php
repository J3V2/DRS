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
        'office_status',
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
        // Extract the numeric value from the AvgProcessTime string
        $value = (float) explode(' ', $time)[0];

        // Determine the unit of time and convert to seconds
        if (strpos($time, 'hours per day') !== false) {
            return $value * 3600 * 1; // Convert to seconds per hour
        } elseif (strpos($time, 'days per week') !== false) {
            return $value * 3600 * 24; // Convert to seconds per day
        } elseif (strpos($time, 'months per year') !== false) {
            return $value * 3600 * 24 * 30; // Convert to seconds per month
        } elseif (strpos($time, 'years') !== false) {
            return $value * 3600 * 24 * 365; // Convert to seconds per year
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
        $years = floor($seconds / (3600 * 24 * 365));
        $remainingSeconds = $seconds % (3600 * 24 * 365);

        // Calculate months and remaining seconds
        $months = floor($remainingSeconds / (3600 * 24 * 30));
        $remainingSeconds %= (3600 * 24 * 30);

        // Calculate days and remaining seconds
        $days = floor($remainingSeconds / (3600 * 24));
        $remainingSeconds %= (3600 * 24);

        // Calculate hours
        $hours = floor($remainingSeconds / 3600);

        // Construct the formatted string
        $formattedString = '';
        if ($years > 0) {
            $formattedString .= "$years years, ";
        }
        if ($months > 0) {
            $formattedString .= "$months months per year, ";
        }
        if ($days > 0) {
            $formattedString .= "$days days per week, ";
        }
        if ($hours > 0) {
            $formattedString .= "$hours hours per day, ";
        }

        // Remove trailing comma and space
        $formattedString = rtrim($formattedString, ', ');

        return $formattedString;
    }
}
