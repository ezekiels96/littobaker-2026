<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WvacAttendance extends Model
{
    protected $table = 'wvac_attendance';

    protected $fillable = ['attendee_id', 'service', 'service_date'];

    protected $casts = ['service_date' => 'date'];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(WvacAttendee::class, 'attendee_id');
    }
}
