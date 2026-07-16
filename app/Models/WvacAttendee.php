<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WvacAttendee extends Model
{
    protected $table = 'wvac_attendees';

    protected $fillable = ['name', 'name_zh', 'service', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function attendance(): HasMany
    {
        return $this->hasMany(WvacAttendance::class, 'attendee_id');
    }
}
