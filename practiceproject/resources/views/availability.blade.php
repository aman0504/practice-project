<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<title>lite picker</title>

<body>

    <div>
        <label>Date</label>
        <input type="text" name="date_time" id="date_time"></input>
        <a href="{{ route('enableSelectedDates', 'hello') }}"> TRY </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        function init() {

            var $dayArray = @json($dayArray); // $dayArray get value from controller
            console.log($dayArray);
            const picker = new Litepicker({

                element: document.getElementById('date_time'),

                selectable: true,
                selectHelper: true,

                select: function(start) {
                    debugger;
                    console.log('start');
                },

                // this function used for selected date and use ajax to pass date in controller
                setup: (picker) => {

                    picker.on('selected', (date) => {

                        var getDate = date.format('YYYY-MM-DD');

                        var data = {
                            "_token": "{{ csrf_token() }}",
                            "date": getDate
                        };
                        console.log(data, "rrrr");

                        $.ajax({
                            type: "POST",
                            url: '/getDay/',
                            data: data,
                            success: function() {
                                console.log("Valueadded");
                            }
                        });
                    });


                    // picker.on('render:day', (day, date) => {

                    // 	var getDay = day;
                    // 	console.log(getDay, 'kk');
                    // });

                },


                lockDaysFilter: (day) => {
                    const d = day.getDay();
                    // console.log(d);    //print all weekdays
                    if (!$dayArray.includes(d)) {

                        return true;
                    }
                    // return [0,1,2,4,6].includes(d);
                    return false;
                },


            });

        }

        window.addEventListener('load', () => {

            init();
        });
    </script>

</body>

</html>
