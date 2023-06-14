<!DOCTYPE html>
<html lang="en">

<head>
    {{-- cdn for intlTELINput --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>




    <script>
        // hack to get the plugin to work without loading jQuery
        window.jQuery = window.$ = function() {
            return {
                on: function() {}
            };
        };
        window.$.fn = {};
    </script>

    <script src="https://codepen.io/jackocnr/pen/ggzEjv.js"></script>


</head>

<body>

    <style>
        body {
            margin: 20px;
        }
    </style>

    <div>
        <h1>country code </h1>


        <h1>Demo: Pure JavaScript International Telephone Input</h1>
        <p>Note: this demo pulls in the pure JavaScript plugin code from <a href="https://codepen.io/jackocnr/pen/ggzEjv"
                target="_blank">this codepen</a>.</p>

        <form>

            <input type="tel" valu="2">
            <input type="tel" value="3" id="code" name="code">

            <input type="hidden" id="country_code" value="" name= "countryCode">   // to get value of ajax variable


        </form>

    </div>

    <script>


        var input = document.querySelector("input");
        //   var  form = document.querySelector("form");
        // result = document.querySelector("#result");

        console.log(input);
        // var iti = intlTelInput(input, {
        //     initialCountry: "us",
        //     formatOnDisplay: true,

        // });

        // form.addEventListener("submit", function(e) {
        //     e.preventDefault();
        //     var num = iti.getNumber(),
        //         valid = iti.isValidNumber();
        //         // debugger;
        //     result.textContent = "Number: " + num + ", valid: " + valid;
        // }, false);

        // input.addEventListener("focus", function() {
        //     result.textContent = "";
        // }, false);

        //  ABOVE ALL CODE IS WORKING IF ONLY ONE INPUT TEXT IS AVAILABLE

        var input = document.querySelector("#code");


        var iti = window.intlTelInput(input, ({

            initialCountry: "us", //set bydefault country
            // formatOnDisplay: true,
            separateDialCode: true, //to show country code with flag
            // initialCountry: ""
            hiddenInput: "full",
            // utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"

        }));



        input.addEventListener("countrychange", function() {

            let getCode = iti.getSelectedCountryData(); //get country name and code
            let countryCode = getCode.dialCode; //get only country code
            console.log(countryCode);
            console.log(getCode);


            $('#country_code').val(countryCode);

        });
    </script>
</body>

</html>


{{--

$(document).ready(function(){
    $("#sendScriptCode").click(function(){
        var scriptCode = "your_script_code_here";
        $.ajax({
            url: "/your-controller-url",
            type: "POST",
            data: { scriptCode: scriptCode },
            success: function(data){
                // handle success
            },
            error: function(xhr, textStatus, errorThrown){
                // handle error
            }
        });
    });
}); --}}
