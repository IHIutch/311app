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
           
            <?php $data = showTable(); 
                foreach($data as $d){ ?>
                <div class="row">
                    <div class="col"><?php echo $d['id']?></div>
                    <div class="col"><?php echo $d['submission_date']?></div>
                    <div class="col"><?php echo $d['lat']?></div>
                    <div class="col"><?php echo $d['lng']?></div>
                    <div class="col"><?php echo $d['email']?></div>
                    <div class="col"><?php echo $d['type']?></div>
                    <div class="col"><?php echo $d['subtype']?></div>
                    <div class="col"><a href="/report.php?report_id=<?php echo $d['id']?>">Link</a></div>
                </div>
                <?php } ?>

        </div>
    </div>
</div>

<? include "inc/footer.php"?>