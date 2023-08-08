<?php

namespace App\Http\Livewire\Availability;

use App\Models\CleanerAvailability;
use App\Models\CleanerAvailabilityDayTime;
use Livewire\Component;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProfileAvailabilty extends Component
{
    // use LivewireAlert;
    public $userId;
    public $days = [];
    public $availablityData = [];
    public $users_id, $timeList;


    public function mount()
    {
        $this->userId = auth()->user()->id;

        //get timezone
        $this->timeList = User::getTime();

        // 1. dd($this->days); get all days with status and time.
        $this->days = User::getDays();

        $this->listAvailabilityDays();
    }

    public function checkBoxOnOff($key)
    {
        $this->days[$key]['status'] = !$this->days[$key]['status'];
    }

    public function listAvailabilityDays()
    {
        // Initialize an array to store availability data for each day
        $dataArray = [];
        // 5. fetch data from db and show .
        foreach ($this->days as $day) {
            $existingAvailabilityday = CleanerAvailability::with('availabilityTime')
                ->where('users_id', $this->userId)
                ->where('day', $day['day'])->first();

            // 6. Initialize availability data for this day with default values
            $availabilityData = [
                'day' => $day['day'],
                'status' => false,
                'time' => [['start_time' => '', 'end_time' => '']],
            ];

            // 7. If CleanerAvailabilityDay record exists for this day, update availability data

            if ($existingAvailabilityday) {
                $availabilityData['status'] = $existingAvailabilityday->status;

                // If availabilityTime is not empty, update 'time' array with start and end times
                if ($existingAvailabilityday->availabilityTime->isNotEmpty()) {
                    $availabilityData['time'] = $existingAvailabilityday->availabilityTime->map(function ($time) {
                        return [
                            'start_time' => $time->start_time,
                            'end_time' => $time->end_time,
                        ];
                    })->toArray();
                }
            }
                  // Add availability data for this day to the dataArray
            $dataArray[] = $availabilityData;
        }


        // Update the 'days' property with the availability data for each day
        $this->days = $dataArray;
    }


    //... daysRequiredTime()used to check all days status (checked or unchecked), so that put validation on only checked days.
    public function daysRequiredTime()
    {
        // Check if any day has its status set to true (checkbox is checked)

        foreach ($this->days as $day) {
            if ($day['status']) {
                return true;
            }
        }
        return false;
    }

    public function store()
    {
        if ($this->daysRequiredTime()) {
            // Validate time slots only when they are shown (checkbox is checked)
            // Validate start_time and end_time for each day's time slot
            $this->validate(
                [
                    'days.*.time.*.start_time' => 'required_if:days.*.status,true',
                    'days.*.time.*.end_time' => 'required_if:days.*.status,true|after:days.*.time.*.start_time',
                ],
                [
                    'days.*.time.*.start_time.required_if' => 'The start time must be required',
                    'days.*.time.*.end_time.required_if' => 'The end time must be required',
                    'days.*.time.*.end_time.after' => 'The day\'s end time field must be after the start time.'
                ]
            );
        } else {
            // Remove validation rules for time slots when they are not shown (checkbox is unchecked)
            $this->resetValidation([
                'days.*.time.*.start_time',
                'days.*.time.*.end_time',
            ]);
        }

        //1. save all days with default status 0 for logged in user in CleanerAvailabilityDays table.
        foreach ($this->days as $day) {
            $availablityDay = CleanerAvailability::updateOrCreate(
                [
                    'users_id' => $this->userId,
                    'day' => $day['day'],
                ],
                [
                    'status' => $day['status'] ? '1' : '0',
                ]
            );


            //2.delete existing availability time for the day
            CleanerAvailabilityDayTime::where('availability_days_id', $availablityDay->id)->delete();

            //3. Save new availability times for the day

            foreach ($day['time'] as $time) {
                if (!empty($time) && !empty($time['start_time']) && !empty($time['end_time'])) {
                    $availabilityTimes[] = [
                        'availability_days_id' => $availablityDay->id,
                        'start_time' => $time['start_time'],
                        'end_time' => $time['end_time'],
                        'created_at' => now(),
                        'updated_at' => now(),

                    ];
                }
            }
        }
        // 4. Use bulk insert to insert all availability times in a single query
        if (!empty($availabilityTimes)) {
            // dd( $availabilityTimes);

            CleanerAvailabilityDayTime::insert($availabilityTimes);
        }

        // $this->alert('success', 'Availability saved successfully');
    }

    public function removeTime($dayIndex, $timeIndex)
    {
        unset($this->days[$dayIndex]['time'][$timeIndex]);
        $this->days[$dayIndex]['time'] = array_values($this->days[$dayIndex]['time']); // Re-index the array
    }

    public function addTimeSlot($key)
    {
        $this->days[$key]['time'][] = [
            'start_time' => '',
            'end_time' => '',
        ];
    }

    public function render()
    {
        return view('livewire.availability.profile-availabilty');
    }
}
