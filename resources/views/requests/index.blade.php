<div id="map" style="height:500px;width:100%;"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
<script>
    let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: {lat: 6.9271, lng: 79.8612} // Colombo example
    });

    let requests = @json($requests);

    requests.forEach(req => {
        new google.maps.Marker({
            position: {lat: parseFloat(req.latitude), lng: parseFloat(req.longitude)},
            map: map,
            title: req.address
        });
    });
</script>
