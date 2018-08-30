<?php include "inc/header.php"?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js" integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q==" crossorigin=""></script>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Integrations</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 bg-light">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h1">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button class="btn btn-sm btn-outline-secondary">Share</button>
                                <button class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">This week</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="info">

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2>Section title</h2>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Submit Date</th>
                                            <th scope="col">Lat</th>
                                            <th scope="col">Lng</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Subtype</th>
                                            <th scope="col">Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $data = showTable(); 
                                            foreach($data as $d){ ?>
                                        <tr>
                                            <th scope="row">
                                                <?php echo $d['id']?>
                                            </th>
                                            <td>
                                                <?php echo $d['submission_date']?>
                                            </td>
                                            <td>
                                                <?php echo $d['lat']?>
                                            </td>
                                            <td>
                                                <?php echo $d['lng']?>
                                            </td>
                                            <td>
                                                <?php echo $d['email']?>
                                            </td>
                                            <td>
                                                <?php echo $d['type']?>
                                            </td>
                                            <td>
                                                <?php echo $d['subtype']?>
                                            </td>
                                            <td><a href="report.php?report_id=<?php echo $d['id']?>">Link</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>


<script>
    var map = L.map('map').setView([42.8864, -78.8784], 12);

    L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiamJodXRjaCIsImEiOiJjamRqZGU1eTYxMTZlMzNvMjV2dGxzdG8wIn0.IAAk5wKeLXOUaQ4QYF3sEA'
    }).addTo(map);

    <?php $points = getPoints();?>
    var points = <?php echo json_encode($points['features']); ?>;

    var pointStyle = {
        radius: 4,
        color: "#ff0000",
        weight: 0,
        opacity: 1,
        fillOpacity: 1
    };

    function style(feature) {
        switch (feature.properties.type) {
            case 'Streets & Sidewalks':
                return {
                    color: '#00FF57'
                };
            case 'Request a Bike Rack':
                return {
                    color: '#FF5500'
                };
            default:
                return {
                    color: 'white'
                };
        }
    };

    L.geoJSON(points, {
        style: style,
        pointToLayer: function(feature, latlng) {
            return L.circleMarker(latlng, pointStyle);
        }
    }).addTo(map);

</script>


<?php include "inc/footer.php"?>
