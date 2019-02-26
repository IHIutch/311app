<?php include "inc/header.php"?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 mb-4 col-md-3 mb-md-0">
                    <div class="p-2 border shadow rounded">
                        <div class="embed-responsive embed-responsive-1by1">
                            <div id="map" class="embed-responsive-item"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="mb-2">
                        <div class="d-inline-block mr-5">
                            <a class="border rounded d-inline-block p-1" href="<?php echo $report->id; ?>">Report ID:
                                <?php echo $report->id; ?></a>
                        </div>
                        <div class="d-inline-block">
                            <span><b>Status: </b></span><span class="badge badge-pill status-<?php echo preg_replace("/[\s_]/", "-" , strtolower($report->status)); ?>">
                                <?php echo $report->status; ?></span>
                        </div>
                    </div>
                    <div>
                        <span class="text-muted">
                            <?php echo $report->type; ?></span>
                    </div>
                    <div>
                        <h1>
                            <?php echo $report->subtype; ?>
                        </h1>
                    </div>
                    <div class="mb-4">
                        <div class="d-inline">
                            <?php echo $report->street_num . " " . $report->street_name . ", " . $report->zip; ?>
                        </div>
                        <div class="d-inline">
                            <span class="text-muted">
                                <?php echo "(" . $report->lat . ", " . $report->lng . ")"; ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="d-inline mr-4">
                            <?php $open = strtotime($report->submission_date); ?>
                            <b>Open Date:</b>
                            <?php echo date("F d, Y", $open); ?>
                        </div>
                        <div class="d-inline">
                            <?php  ?>
                            <b>Closed Date:</b>
                            <?php 
                                if($report->closed_date != null){
                                    $closed = strtotime($report->closed_date);
                                    echo date("F d, Y", $closed);
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-none d-md-block">
                    <div class="text-uppercase small mb-2"><b>Share</b></div>
                    <div class="btn btn-secondary" id="fbShare"><i class="fab fa-facebook"></i></div>
                    <div class="btn btn-secondary" id="twShare"><i class="fab fa-twitter"></i></div>
                    <div class="btn btn-secondary" onClick="copyLink()" id="copyLink"><i class="fas fa-link"></i></div>
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
                        <?php echo $report->comments; ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <b>Photos:</b>
                        </div>
                        
                        <?php $images = json_decode($report->image);
                        foreach($images as $i){ ?>
                        <div class="col-6">
                            <a href="#" class="embed-responsive embed-responsive-1by1 mb-2">
                                <img src="<?php echo $i; ?>" class="w-100 img-thumbnail embed-responsive-item" style="object-fit: cover;" data-toggle="modal" data-target="#imageModal">
                            </a>
                        </div>
                        <?php };?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"; ?>
