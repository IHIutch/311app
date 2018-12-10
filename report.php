<?php include "inc/header.php";

$admin = $_SESSION['admin'];
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php $info = getInfo();?>
                <div class="col-3">
                    <div id="map-holder" class="p-2 border shadow rounded">
                        <div id="map" class="w-100"></div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="mb-2">
                        <div class="d-inline-block mr-5">
                            <a class="border rounded d-inline-block p-1" href="/report.php?report_id=<?php echo $info['id']; ?>">Report ID:
                                <?php echo $info['id']; ?></a>
                        </div>
                        <?php 
                            if(!$admin){ ?>
                        <div class="d-inline-block">
                            <span><b>Status: </b></span><span class="badge badge-pill badge-warning">
                                <?php echo $info['status']; ?></span>
                        </div>
                        <?php }else{ ?>
                            <span><b>Status: </b></span>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                    <span class="badge badge-pill badge-warning">
                                <?php echo $info['status']; ?></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item"><span class="badge badge-pill badge-warning">Under Review</span></a>
                                    <a href="#" class="dropdown-item"><span class="badge badge-pill badge-warning">Assigned</span></a>
                                    <a href="#" class="dropdown-item"><span class="badge badge-pill badge-warning">Completed</span></a>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <div>
                        <span class="text-muted">
                            <?php echo $info['type']; ?></span>
                    </div>
                    <div>
                        <h1>
                            <?php echo $info['subtype']; ?>
                        </h1>
                    </div>
                    <div class="mb-4">
                        <div class="d-inline">
                            <?php echo $info['street_num'] . " " . $info['street_name'] . ", " . $info['zip']; ?>
                        </div>
                        <div class="d-inline">
                            <span class="text-muted">
                                <?php echo "(" . $info['lat'] . ", " . $info['lng'] . ")"; ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="d-inline mr-4">
                            <?php $open = strtotime($info['submission_date']); ?>
                            <b>Open Date:</b>
                            <?php echo date("F d, Y", $open); ?>
                        </div>
                        <div class="d-inline">
                            <?php $closed = strtotime($info['closed_date']); ?>
                            <b>Closed Date:</b>
                            <?php echo date("F d, Y", $closed); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr class="my-4">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-2">
                        <b>Description:</b>
                    </div>
                    <div>
                        <?php echo $info['comments']; ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <b>Photos:</b>
                        </div>
                        <?php 
                        if(getImages()){
                            $images = getImages();
                            foreach($images as $key){
                                foreach($key as $k => $v){
                                    echo '<div class="col-6"><img src="uploads/'.$v.'" class="w-100 img-thumbnail"></div>';
                                }
                            };
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    $pointData = getSinglePoint(); ?>
</div>

<script>
    <?php 
    $latlng = $pointData['features']['geometry']['coordinates'];
    [$latlng[0], $latlng[1]] = [$latlng[1], $latlng[0]];
    
//    $latlng = json_encode($latlng);
    
    
    ?>
    
    var map = L.map('map').setView([<?php echo implode(",", $latlng); ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiamJodXRjaCIsImEiOiJjamRqZGU1eTYxMTZlMzNvMjV2dGxzdG8wIn0.IAAk5wKeLXOUaQ4QYF3sEA'
    }).addTo(map);

    var point = <?php echo json_encode($pointData['features']); ?>;

    var pointStyle = {
        radius: 6,
        color: "#ff0000",
        weight: 16,
        opacity: .4,
        fillOpacity: 1
    };

    function style(feature) {
        switch (feature.properties.subject) {
            case 'Dept of Public Works':
                return {
                    color: '#f3bc7d'
                };
            case 'Office of Strategic Planning':
                return {
                    color: '#5a0082'
                };
            case 'Office of the Mayor':
                return {
                    color: '#ef30a4'
                };
            case 'DPIS':
                return {
                    color: '#371b7a'
                };
            case 'Utilities':
                return {
                    color: '#b3ad00'
                };
            case 'Human Resources':
                return {
                    color: '#4ba2ff'
                };
            case 'Dept of Law':
                return {
                    color: '#c52b06'
                };
            case 'Assessment & Taxation':
                return {
                    color: '#2bdebe'
                };
            case 'Buffalo Fire Department':
                return {
                    color: '#c6001d'
                };
            case 'Community Services & Rec. Program':
                return {
                    color: '#6cdc8c'
                };
            case 'Buffalo Municipal Housing Authority':
                return {
                    color: '#7a0069'
                };
            case 'Buffalo Police Department':
                return {
                    color: '#019457'
                };
            case 'Dept of Parking':
                return {
                    color: '#ff3561'
                };
            case 'City Clerk':
                return {
                    color: '#019895'
                };
            case 'Miscellaneous':
                return {
                    color: '#629d00'
                };
            default:
                return {
                    color: 'red'
                };
        }
    };

    L.geoJSON(point, {
        style: style,
        pointToLayer: function(feature, latlng) {
            return L.circleMarker(latlng, pointStyle);
        }
    }).addTo(map);

</script>

<?php include "inc/footer.php"?>
