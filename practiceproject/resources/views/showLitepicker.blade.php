<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @livewireStyles
</head>

<body>
    {{-- <a href="https://calendar.google.com/calendar/u/0?cid=aXR4YW1hbmRlZXBrYXVyQGdtYWlsLmNvbQ">Click on me to move on google calendar </a> --}}

    <b class="link-design-2">
        Add to calendar </a>
        <a
            href="https://outlook.live.com/owa/calendar/00000000-0000-0000-0000-000000000000/cc3e564f-da07-40f6-ad66-6ef95dbf24f8/cid-A4325673DE0DAAEA/index.html">
            <i class="fa-brands fa-microsoft"></i></a>
        <a href="https://calendar.google.com/calendar/u/0?cid=aXR4YW1hbmRlZXBrYXVyQGdtYWlsLmNvbQ"><i
                class="fa-brands fa-google"></i></a>
    </b>

    @livewire('litepicker')


    @stack('scripts')

    @livewireScripts

</body>

</html>
