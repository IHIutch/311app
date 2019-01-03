<?php 

include "inc/header.php";

if(isset($_SESSION['admin'])){
    $admin = $_SESSION['admin'];
}else{
    $admin = false;
}

if(isset($_POST['status'])){
    updateStatus($_GET['report_id'], $_POST['status']);
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php $info = getInfo();?>
                <div class="col-12 mb-4 col-md-3 mb-md-0">
                    <div class="p-2 border shadow rounded">
                        <div class="embed-responsive embed-responsive-1by1">
                            <div id="map" class="embed-responsive-item"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="mb-2">
                        <div class="d-inline-block mr-5">
                            <a class="border rounded d-inline-block p-1" href="/report.php?report_id=<?php echo $info['id']; ?>">Report ID:
                                <?php echo $info['id']; ?></a>
                        </div>
                        <?php 
                            if(!$admin){ ?>
                        <div class="d-inline-block">
                            <span><b>Status: </b></span><span class="badge badge-pill status-<?php echo preg_replace("/[\s_]/", "-", strtolower($info['status'])); ?>">
                                <?php echo $info['status']; ?></span>
                        </div>
                        <?php }else{ ?>
                        <span><b>Status: </b></span>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                                <span class="badge badge-pill status-<?php echo preg_replace("/[\s_]/", "-", strtolower($info['status']));?>">
                                    <?php echo $info['status']; ?></span>
                            </button>
                            <div class="dropdown-menu">
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#confirmationModal"><span id="statusReview" class="badge badge-pill">Under Review</span></a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#confirmationModal"><span id="statusAssigned" class="badge badge-pill">Assigned</span></a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#confirmationModal"><span id="statusScheduled" class="badge badge-pill">Scheduled</span></a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#confirmationModal"><span id="statusCompleted" class="badge badge-pill">Completed</span></a>
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
                            <?php  ?>
                            <b>Closed Date:</b>
                            <?php 
                                if($info['closed_date'] != null){
                                    $closed = strtotime($info['closed_date']);
                                    echo date("F d, Y", $closed);
                                }
                            ?>
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
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <b>Photos:</b>
                        </div>
                        <?php 
                        if(getImages()){
                            $images = getImages();
                            foreach($images as $key){
                                foreach($key as $k => $v){ ?>
                        <div class="col-6">
                            <a href="#" class="embed-responsive embed-responsive-1by1 mb-2">
                                <img src="uploads/<?php echo $v; ?>" class="w-100 img-thumbnail embed-responsive-item" style="object-fit: cover;" data-toggle="modal" data-target="#imageModal">
                            </a>
                        </div>
                        <?php }
                            };
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $pointData = getSinglePoint(); ?>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <img id="zoomedImage" class="w-100 img-thumbnail" src="">
        </div>
    </div>
</div>
<!-- End Image Modal -->

<!-- Modal Start -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Status Change</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body my-3">
                <div class="text-center">
                    <p>Are you sure you want to update this ticket's status to:</p>
                </div>
                <div id="modalStatus" class="text-center">
                        <span class="badge badge-pill p-3"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <form method="post">
                    <input type="hidden" name="status" id="status" value="">
                    <input type="submit" name="confirm" class="btn btn-primary" value="Confirm">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

<script>
    $('#imageModal').on('show.bs.modal', function(event) {
        var modal = $(this)
        var image = $(event.relatedTarget).attr('src')
        $('#zoomedImage').attr('src', image)
    });


    $('#confirmationModal').on('show.bs.modal', function(event) {
        var status = $(event.relatedTarget).find('span').attr('id')
        var text = $(event.relatedTarget).find('span').text()
        var modal = $(this)

        $('#modalStatus').find('span').html(text)
//        $('#modalStatus').find('span').attr('id', status)
        $('#status').val(text)
    });

</script>


<script>
    <?php 
    $latlng = $pointData['features']['geometry']['coordinates'];
    
    //Flip lat, lng
    $temp = $latlng[0];
    $latlng[0] = $latlng[1];
    $latlng[1] = $temp;    
    
    ?>

    var map = L.map('map').setView([<?php echo implode(",", $latlng); ?>], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: '<?php echo env('MAPBOX'); ?>'
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
