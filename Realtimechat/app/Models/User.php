<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public function messageSender()
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    public function messageReceiver()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'id');
    }


    public static function getTime()
    {
        $start = Carbon::now();
        $start = $start->setTime(8, 0, 0);
        $end = Carbon::now()->endOfDay();
        $end = $end->setTime(18, 0, 0);

        // Initialize an empty array to store the time list
        $timeList = [];

        // Loop through the time range with 15-minute intervals and add each time to the array
        while ($start->lt($end)) {
            $timeList[] = $start->format('h:i A');
            $start->addMinutes(15);
        }

        return $timeList;
    }


    // for availability

    public static function getDays()
    {
        $days = [
            ['day' => 'Monday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]],
            ['day' => 'Tuesday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]],
            ['day' => 'Wednesday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]],
            ['day' => 'Thursday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]],
            ['day' => 'Friday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]],
            ['day' => 'Saturday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]],
            // ['day' => 'Sunday', 'status' => false, 'time' => [['start_time' => '', 'end_time' => '']]]
        ];

        return $days;
    }
}
