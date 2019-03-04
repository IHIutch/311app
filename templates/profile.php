<?php include "inc/header.php"?>

<div class="container">
   <div class="row">
       <div class="col-12">
           <div class="pt-5 mt-5 mb-5">
               <h1>Hey, <?php echo $user->email ?></h1>
               <span>Total reports: <?php echo count($reports); ?></span>
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
                            <?php foreach($reports as $report){ ?>
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
                                <td><a href="<?php echo '../report/'.$report->id; ?>">Link</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true
        });
    });

</script>

<?php include "inc/footer.php"; ?>
