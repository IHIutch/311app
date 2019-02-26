<?php include "inc/header.php"; ?>

<div class="container bg-light">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h1">Reports <?php echo $count;?></h1>
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
                        <div class="embed-responsive embed-responsive-21by9">
                            <div id="map" class="embed-responsive-item bg-dark"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-12">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Submit Date</th>
                                        <th scope="col">Coords</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Zip Code</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Subtype</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($report_list as $report){ ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $report->id; ?>
                                        </th>
                                        <td>
                                            <?php echo date('m/d/y', strtotime($report->submission_date)); ?>
                                        </td>
                                        <td>
                                            <?php echo $report->lat . ', ' . $report->lng; ?>
                                        </td>
                                        <td>
                                            <?php echo $report->street_num . ' ' .  $report->street_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $report->zip; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-warning">
                                                <?php echo $report->status; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo $report->type; ?>
                                        </td>
                                        <td>
                                            <?php echo $report->subtype?>
                                        </td>
                                        <td><a href="report.php?report_id=<?php echo $report->id; ?>">Link</a></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
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
    $(document).ready(function() {
        $('#datatable').DataTable({
            select: true,
            responsive: true
        });
    });

</script>

<?php include "inc/footer.php"; ?>
