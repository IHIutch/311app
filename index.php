<?php include "inc/header.php"?>

<div class="container-fluid">
    <div class="row">
        <div class="col-4 max-height">
            <div class="pt-4 px-3">
                <h1>Submit an Issue</h1>
                <form action="thank-you.php" method="post">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>What is the type?</label>
                            <select class="form-control" name="type">
							<option value="Streets & Sidewalks">Streets &amp; Sidewalks</option>
						</select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the subtype?</label>
                            <select class="form-control" name="subtype">
							<option value="Request for Paving">Request for Paving</option>
							<option value="Problem with a Traffic Sign">Problem with a Traffic Sign</option>
							<option value="Request a Crosswalk">Request a Crosswalk</option>
							<option value="Report a Pothole">Report a Pothole</option>
							<option value="Request a Bike Rack">Request a Bike Rack</option>
							<option value="Report Faded Street Lines">Report Faded Street Lines</option>
							<option value="Inspect or Repair a Sidewalk">Inspect or Repair a Sidewalk</option>							
						</select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the location of the issue?</label>
                            <input type="text" name="address" class="form-control" placeholder="123 Main Street...">
                        </div>
                        <div class="form-group col-12">
                            <label>What is your email?</label>
                            <input type="email" name="email" class="form-control" placeholder="johndoe@email.com">
                        </div>
                        <div class="form-group col-12">
                            <label>Additional Comments</label>
                            <textarea class="form-control" name="comments" rows="3" placeholder="Comments..."></textarea>
                        </div>
                        <div class="form-group col-12">
                            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8">
            <table class="table">
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
                        <th scope="row"><?php echo $d['id']?></th>
                        <td><?php echo $d['submission_date']?></td>
                        <td><?php echo $d['lat']?></td>
                        <td><?php echo $d['lng']?></td>
                        <td><?php echo $d['email']?></td>
                        <td><?php echo $d['type']?></td>
                        <td><?php echo $d['subtype']?></td>
                        <td><a href="report.php?report_id=<?php echo $d['id']?>">Link</a></td>
                    </tr>
                     <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<? include "inc/footer.php"?>
