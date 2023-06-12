<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Integrate Google Map</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        #map {
          height: 400px;
          width: 900px;
        }
    </style>
</head>

<body>

    <div>
        <h4> Google Map Integration </h4>
        <div id="map"></div>


    </div>

    {{-- <script type="text/javascript">
        function initMap() {
          const myLatLng = { lat: 22.2734719, lng: 70.7512559 };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
          });

          new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Hello Rajkot!",
          });
        }

        window.initMap = initMap;
    </script> --}}
<script>

    function initMap() {
        // Create the map.
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 4,
          center: { lat: 37.09, lng: -95.712 },
          mapTypeId: "terrain",
        });
    }


window.initMap = initMap;
</script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap" ></script>

</body>

</html>
