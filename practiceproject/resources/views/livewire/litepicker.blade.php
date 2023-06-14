<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h3> submit details , it will show, when click on "click me" it will hide</h3>

    <label><b>First name </b></label>
    <input type="text" wire:model="first_name"> <br><br>

    <label><b>Last name </b></label>
    <input type="text" wire:model="last_name"> </b><br><br>

    <label> <b>Email </b> </label>
    <input type="text" wire:model="email"> </b><br><br>

    <label> <b>Password </b> </label>
    <input type="password" wire:model="password"> </b><br><br>

    <a href="javascript::void(0)" type="submit" wire:click="store()">Submit</a>

    <br> <br> <br> <br>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        @foreach ($userDetails as $userDetail)
            @if ($userDetail->status == '0')
                <div class="row border" value="{{ $userDetail->status }}">
                    <div class="col-lg-3">
                        <p>{{ $userDetail->first_name }}</p>
                    </div>
                    <div class="col-lg-3">
                        <p>{{ $userDetail->last_name }}</p>
                    </div>
                    <div class="col-lg-3 border">
                        <p>{{ $userDetail->status }}</p>
                    </div>
                    <div class="col-lg-3">
                        <a href="javascript::void(0)" type="submit" wire:click="statusChange({{ $userDetail->id }})">
                            Click Me </a>
                    </div>
                </div>
            @endif
        @endforeach

    </div>



    {{-- @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
        <script>
            function init() {
                const picker = new Litepicker({
                    element: document.getElementById('litepicker')
                });

            }

            window.addEventListener('load', () => {

                init();
            });
        </script>
    @endpush --}}
</div>
