<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}">

    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.2/js/intlTelInput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.2/js/utils.js"></script> --}}

    {{-- <link rel="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/9.0.6/css/intlTelInput.css">
    <link rel="http://intl-tel-input.com/node_modules/intl-tel-input/build/css/demo.css?3"> --}}

    {{-- selec2 cdn --}}


</head>

<body class="antialiased">





    <div>
        <a href="{{ route('register') }}"> Registration </a> &nbsp &nbsp
        <a href="{{ route('login') }}"> Login </a>
    </div>

    <div>
        <a href="{{ route('availability') }}">
            <h2><b>1..... Availability</b></h2>
        </a> <br>
        <a href="{{ route('countrycode') }}">
            <h2><b>1..... Country Code</b></h2>
        </a> <br>

        <a href="{{ route('enableSelectedDates') }}">
            <h2>2..........Litepicker</h2>
        </a>

        <a href="{{ route('index1.goog') }}">
            <h2>3..........Gmap</h2>
        </a>

        <a href="{{ route('map.googleMap') }}">
            <h2>4..........GoogleMap</h2>
        </a>

        <a href="{{ route('spatieimage.create') }}">
            <h2>5..........Image Save using Spatie package </h2>
        </a>

        <a href="{{ route('payment.show') }}">
            <h2>6..........Stripe Payment </h2>
        </a>
        <a href="{{ route('bankinfo.index') }}">
            <h2>7..........Stripe connect account Payout </h2>
        </a>

        <a href="{{route('selectMultipleIndex')}}">
            <h2>8........... MutiSelector 2 </h2>
        </a>
    </div>

    <div>
        <h4><b>Task for encrypt and decrypte </b></h4>

        <form action="{{ route('create') }}" method="POST">
            @csrf
            <label>NAME </label>
            <input type="text" name='name'> <br>
            <br>
            <label>Email </label>
            <input type="text" name='email'> <br>
            <br>
            <label>CODE </label>
            <input type="text" name='code'> <br>
            <br>
            <button type="submit">Submit</button>
        </form>

    </div>

    <div>
        <label>Phone with country Code </label>
        <h1>Demo: Pure JavaScript International Telephone Input</h1>
        <p>Note: this demo pulls in the pure JavaScript plugin code from <a
                href="https://codepen.io/jackocnr/pen/ggzEjv" target="_blank">this codepen</a>.</p>

        <form>
            <input type="tel">
            <button type="submit">Validate</button>
        </form>

        <p id="result"></p>

    </div>


    <div>

        <a href="{{ route('incrementDecrement') }}"> Increment/Decrement</a>


        <input type="text" id="demoForm">
    </div>


    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="{{ asset('js/intlTelInput-jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.35.3/es6-shim.min.js"></script>
    <script src="/vendors/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/vendors/formvalidation/dist/js/plugins/InternationalTelephoneInput.min.js"></script>
    <script>
        var input = document.querySelector("input"),
            form = document.querySelector("form"),
            result = document.querySelector("#result");

        var iti = intlTelInput(input, {
            initialCountry: "us"
        });

        form.addEventListener("submit", function(e) {
            e.preventDefault();
            var num = iti.getNumber(),
                valid = iti.isValidNumber();
            result.textContent = "Number: " + num + ", valid: " + valid;
        }, false);

        input.addEventListener("focus", function() {
            result.textContent = "";
        }, false);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            FormValidation.formValidation(
                document.getElementById('demoForm'), {
                    fields: {
                        ...
                    },
                    plugins: {
                        internationalTelephoneInput: new FormValidation.plugins.InternationalTelephoneInput({
                            autoPlaceholder: '...',
                            field: '...',
                            message: '...',
                            utilsScript: '...',
                        }),
                        ...
                    },
                }
            );
        });
    </script>

</body>

</html>
