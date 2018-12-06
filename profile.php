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
                            <th scope="col">Lat</th>
                            <th scope="col">Lng</th>
                            <th scope="col">Email</th>
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
</div>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            select: true,
            responsive: true
        });
    });

</script>

<?php include "inc/footer.php";
