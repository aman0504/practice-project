<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleanerAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'day', 'status',
    ];

    public function availabilityTime()
    {
        return $this->hasMany(CleanerAvailabilityDayTime::class, 'availability_days_id', 'id');
    }
}
