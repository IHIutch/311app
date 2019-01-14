<?php 
include "inc/header.php";

if(!$_SESSION['logged']){ 
    header("Location: login.php"); 
    exit; 
};

$email = $_SESSION['email']; 
?>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5 mb-3">
            <h1>Welcome
                <?php echo $email; ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-12">
            <div class="p-4 bg-white rounded shadow-sm">
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
                        <?php $data = showUserData($email); 
                        foreach($data as $d){ ?>
                        <tr>
                            <th scope="row">
                                <?php echo $d['id']?>
                            </th>
                            <td>
                                <?php echo date('m/d/y', strtotime($d['submission_date']))?>
                            </td>
                            <td>
                                <?php echo $d['lat'] . ', ' . $d['lng']?>
                            </td>
                            <td>
                            <?php echo $d['street_num'] . ' ' .  $d['street_name']?>
                            </td>
                            <td>
                                <?php echo $d['zip'] ?>
                            </td>
                            <td>
                                <span class="badge badge-pill status-<?php echo preg_replace("/[\s_]/", "-", strtolower($d['status']));?>">
                                                <?php echo $d['status'] ?></span>
                            </td>
                            <td>
                                <?php echo $d['type']?>
                            </td>
                            <td>
                                <?php echo $d['subtype']?>
                            </td>
                            <td>
                                <a href="report.php?report_id=<?php echo $d['id']?>">Link</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
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

<?php include "inc/footer.php";
