<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

</head>

<body class="antialiased">

<div>
<a href="{{route('register')}}"> Registration </a> &nbsp &nbsp
<a href= "{{route('login')}}" > Login </a>
</div>

    <div>
        <a href="{{ route('availability') }}">
            <h2><b>1..... Availability</b></h2>
        </a> <br>


        <a href="{{ route('enableSelectedDates') }}">
            <h2>2..........Litepicker</h2>
        </a>

        <a href="{{ route('index1.goog') }}">
            <h2>3..........Gmap</h2>
        </a>


    </div>

    <div>
        <h4><b>Task for encrypt and decrypte </b></h4>

        <form action="{{route('create')}}" method="POST" >
@csrf
        <label>NAME </label>
        <input type="text" name='name'> <br>
        <br>
        <label>Email </label>
        <input type="text" name='email'> <br>
        <br>
        <label>CODE </label>
        <input type="text" name= 'code'> <br>
        <br>
        <button type= "submit">Submit</button>
        </form>

    </div>


    <div>

        <a href="{{route('incrementDecrement')}}"> Increment/Decrement</a>
    </div>
</body>

</html>
