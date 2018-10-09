<?php include "inc/header.php"?>
<div class="container bg-light">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h1">Reports</h1>
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
            <div class="row">
                <div class="col-12">
                    <div class="mb-3 p-4 bg-white rounded shadow-sm">
                        <div id="map">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-12">
                    <div class="p-4 bg-white rounded shadow-sm">
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
                                    <th scope="col"></th>
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
                                        <?php echo date('m.d.y', strtotime($d['submission_date']))?>
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
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="Page navigation" class="d-inline-block">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
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