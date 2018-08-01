<?php include "../lib/db.php";?>
<?php include "functions.php";?>

<?php include "inc/header.php"?>

<div class="container-fluid">
    <div class="row">
        <div class="col-4 max-height">
            <div class="pt-4 px-3">
                <h1>Submit an Issue</h1>
                <form>
                    <div class="row">
                        <div class="form-group col-12">
                            <label>What is the type?</label>
                            <select class="form-control">
							<option>This</option>
							<option>That</option>
						</select>
                        </div>
                        <div class="form-group col-12">
                            <label>More specific issue</label>
                            <select class="form-control">
							<option>Spec this</option>
							<option>Spec that</option>
						</select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the location of the issue?</label>
                            <input type="text" name="address" class="form-control" placeholder="123 Main Street...">
                        </div>
                        <div class="form-group col-12">
                            <button class="btn btn-primary">Use Current Location</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8 max-height px-0">
            <div class='map-overlay'>
                <div id='markers'></div>
            </div>

            <div id="mapid"></div>

            <script>
                var mymap = L.map('mapid').setView([42.8864, -78.8784], 10);
                var marker = L.marker([42.8864, -78.8784]).addTo(mymap);


                L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/256/{z}/{x}/{y}@2x?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox.streets',
                    accessToken: 'pk.eyJ1IjoiamJodXRjaCIsImEiOiJjamRqZGU1eTYxMTZlMzNvMjV2dGxzdG8wIn0.IAAk5wKeLXOUaQ4QYF3sEA'
                }).addTo(mymap);


                var popup = L.popup();

                function onMapClick(e) {
                    popup
                        .setLatLng(e.latlng)
                        .setContent("You clicked the map at " + e.latlng.toString())
                        .openOn(mymap);
                }

                mymap.on('click', onMapClick);

            </script>

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
