<div>


    @foreach ($days as $key => $day)
        {{-- @dd($day); --}}
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="days[{{ $key }}][status]"
                wire:click="checkBoxOnOff({{ $key }})" id="flexSwitchCheckDefault{{ $key }}"
                @if ($day['status']) checked @endif>
            <label class="form-check-label" for="flexSwitchCheckDefault">{{ $day['day'] }}</label>

        </div>

        <div>
            @if ($day['status'])
                @foreach ($day['time'] as $index => $time)
                    <div class="row my-3">
                        <div class="col-lg-3 profile-date-field">
                            {{-- <input type="time"
                                name="days[{{ $key }}][time][{{ $index }}][start_time]"
                                wire:model="days.{{ $key }}.time.{{ $index }}.start_time"
                                class="w-100" /> --}}
                            <select name="days[{{ $key }}][time][{{ $index }}][start_time]"
                                wire:model="days.{{ $key }}.time.{{ $index }}.start_time"
                                class="w-100">
                                <option>Select Time</option>
                                @foreach ($timeList as $time)
                                    <option value="{{ $time }}">{{ $time}}</option>
                                @endforeach

                            </select>

                            @error("days.{$key}.time.{$index}.start_time")
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        to
                        <div class="col-lg-3 profile-date-field">
                            {{-- <input type="time"
                                name="days[{{ $key }}][time][{{ $index }}][end_time]"
                                wire:model="days.{{ $key }}.time.{{ $index }}.end_time"> --}}

                                <select name="days[{{ $key }}][time][{{ $index }}][end_time]"
                                wire:model="days.{{ $key }}.time.{{ $index }}.end_time"
                                class="w-100">
                                <option>Select Time</option>
                                @foreach ($timeList as $time)
                                    <option value="{{ $time }}">{{ $time}}</option>
                                @endforeach

                            </select>



                            @error("days.{$key}.time.{$index}.end_time")
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if ($index > 0)
                            <div class="col-lg-1 d-flex align-items-center justify-content-center add-btn">
                                <a href="javascript:void(0)"
                                    wire:click="removeTime({{ $key }}, {{ $index }})"> - </a>
                            </div>
                        @else
                            <div class="col-lg-1 d-flex align-items-center justify-content-center add-btn">
                                <a href="javascript:void(0)" wire:click="addTimeSlot({{ $key }})"> + </a>
                            </div>
                        @endif
                @endforeach
            @endif
        </div>
    @endforeach


    <button class="btn-primary" type="button" wire:click="store()">Submit </button>
</div>
