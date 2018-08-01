<?php include "mapbox2db.php"; ?>
<div id="map"></div>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiamJodXRjaCIsImEiOiJjamRqZGU1eTYxMTZlMzNvMjV2dGxzdG8wIn0.IAAk5wKeLXOUaQ4QYF3sEA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v10',
        center: [-78.87, 42.91],
        zoom: 12
    });


    var markers = document.getElementById('markers');

    map.on('load', function() {

        map.addLayer(
            <?php markers();?>
        );
        
        
        // Create a popup, but don't add it to the map yet.
        var popup = new mapboxgl.Popup({
            closeButton: false,
            closeOnClick: false
        });

        map.on('mouseenter', 'points', function(e) {
            // Change the cursor style as a UI indicator.
            map.getCanvas().style.cursor = 'pointer';

            var coordinates = e.features[0].geometry.coordinates.slice();
            var name = e.features[0].properties.name;
            var address = e.features[0].properties.address;

            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            // Populate the popup and set its coordinates
            // based on the feature found.
            popup.setLngLat(coordinates)
                .setHTML(name + '<br>' + address)
                .addTo(map);
        });

        map.on('mouseleave', 'points', function() {
            map.getCanvas().style.cursor = '';
            popup.remove();
        });
    });

</script>
