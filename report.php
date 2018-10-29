<?php include "inc/header.php"?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php $info = getInfo();?>
                <div class="col-3">
                    <div id="map-holder" class="p-3 border shadow rounded">
                        <div style="background:blue;width:100%;height:200px"></div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="mb-2">
                        <div class="d-inline-block mr-5">
                            <a class="border rounded d-inline-block p-1" href="/report.php?report_id=<?php echo $info['id']; ?>">Report ID:
                                <?php echo $info['id']; ?></a>
                        </div>
                        <div class="d-inline-block">
                            <span><b>Status: </b></span><span class="badge badge-pill badge-warning">Unresolved</span>
                        </div>
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
</div>

<?php include "inc/footer.php"?>
