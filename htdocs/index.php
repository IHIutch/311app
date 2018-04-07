<?php include "db.php";?>
<?php include "functions.php";?>

<?php createRows();?>
<?php include "inc/header.php"?>

<div class="container-fluid">
	<div class="row">
		<div class="col-4 max-height">
			<h1>Submit an Issue</h1>
			<form>
				<div class="form-group">
					<div class="col-12">
						<label>What is th type?</label>
						<select>
							<option>This</option>
							<option>That</option>
						</select>
					</div>
					<div class="col-12">
						<label>More specific issue</label>
						<select>
							<option>Spec this</option>
							<option>Spec that</option>
						</select>
					</div>
					<div class="col-12">
						<label>What is the location of the issue?</label>
						<input type="text" name="address" class="" placeholder="123 Main Street...">
					</div>
					<div class="col-12">
						<button class="btn btn-primary">Use Current Location</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-8 max-height px-0">
			<div id="map"></div>
			<div class='map-overlay'>
				<div id='markers'></div>
			</div>

			<?php include "map_mapbox.php";?>

		</div>
	</div>
</div>

<? include "inc/footer.php"?>



	<!--
 <div cf-context>
				<form cf-form action="index.php" method="post">
					<div class="form-group">
						<input type="text" name="name" class="form-control" cf-questions="What is your name?||Please tell me your name.">
					</div>
					<div class="form-group">
						<input type="text" name="address" class="form-control" cf-questions="What is your address?">
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
							<input cf-questions="What is the type?" type="radio" name="type" value="bar" tabindex="-1">
							Snow
						</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="type" value="restaurant" tabindex="-1">
							Animal
						</label>
						</div>
						<div class="radio">
							<label>
							<input cf-questions="What is the type?" type="radio" name="type" value="bar" tabindex="-1">
							Forestry
						</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="type" value="restaurant" tabindex="-1">
							Sanitation
						</label>
						</div>
						<div class="radio">
							<label>
							<input cf-questions="What is the type?" type="radio" name="type" value="bar" tabindex="-1">
							Housing
						</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="type" value="restaurant" tabindex="-1">
							Parking
						</label>
						</div>
						<div class="radio">
							<label>
							<input cf-questions="What is the type?" type="radio" name="type" value="bar" tabindex="-1">
							Police
						</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="type" value="restaurant" tabindex="-1">
							Streets/Sidewalks
						</label>
						</div>
						<div class="radio">
							<label>
							<input type="radio" name="type" value="restaurant" tabindex="-1">
							Utilities
						</label>
						</div>
					</div>

					<label for="thats-all">Are you ready to submit the form?</label>
					<select cf-questions="Are you ready to submit the form?" name="submit" class="form-control" tabindex="-1">
				        <option></option>
				        <option tabindex="-1">Yes!</option>
				    </select>
					<input class="btn btn-primary" type="submit" name="submit" value="CREATE">
				</form>
			</div>