<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Distance Calculator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Google Maps Distance Calculator</h1>

    <form method="post" action="{{ route('calculate.distance') }}">
        @csrf
        <label for="origin">Origin:</label>
        <input type="hidden" id="origin-input" name="origin">
        <div id="origin-map" style="height: 300px;"></div>

        <label for="destination">Destination:</label>
        <input type="hidden" id="destination-input" name="destination">
        <div id="destination-map" style="height: 300px;"></div>

        <button type="submit">Calculate Distance</button>
    </form>

    @if(isset($distance) && isset($duration))
        <h2>Distance: {{ $distance }}</h2>
        <h2>Duration: {{ $duration }}</h2>
    @endif

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places"></script>
    <script>
        var originInput = document.getElementById('origin-input');
        var destinationInput = document.getElementById('destination-input');
    
        var originMap = new google.maps.Map(document.getElementById('origin-map'), {
            center: {lat: 0.9928103172928537, lng: 104.60844617765906},
            zoom: 13
        });

        var destinationMap = new google.maps.Map(document.getElementById('destination-map'), {
            center: {lat: 0.9928103172928537, lng: 104.60844617765906},
            zoom: 13
        });
    
        var originMarker = new google.maps.Marker({
            map: originMap,
            position: {lat: 0.9928103172928537, lng: 104.60844617765906},
            draggable: true
        });
    
        var destinationMarker = new google.maps.Marker({
            map: destinationMap,
            position: {lat: 0.9928103172928537, lng: 104.60844617765906},
            draggable: true
        });
    
        originMarker.addListener('dragend', function(event) {
            originInput.value = event.latLng.lat() + ',' + event.latLng.lng();
        });
    
        destinationMarker.addListener('dragend', function(event) {
            destinationInput.value = event.latLng.lat() + ',' + event.latLng.lng();
        });
    </script>
</body>
</html>
