<?php include "inc/header.php"?>
<!--
<div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
        <a class="nav-link active" href="#">Dashboard</a>
        <a class="nav-link" href="#">
            Friends
            <span class="badge badge-pill bg-light align-text-bottom">27</span>
        </a>
        <a class="nav-link" href="#">Explore</a>
        <a class="nav-link" href="#">Suggestions</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
    </nav>
</div>
-->
<main role="main" class="container mt-5">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="border-bottom pb-2 mb-3">
                <h1 class="h1">Submit an Issue</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="p-4 bg-white rounded shadow-sm mb-4">
                <form action="thank-you.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>What is the type?</label>
                            <select class="form-control" name="type" id="type">
                                <option selected>Please Select</option>
                                <?php $types = getIssueTypes();
                                    foreach($types as $t){
                                        echo "<option>$t</option>";
                                    };
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the subtype?</label>
                            <select class="form-control" name="subtype" id="subtype">
                                <option>First select a type</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the location of the issue?</label>
                            <input type="text" name="address" class="form-control" id="autocomplete" placeholder="123 Main Street...">
                        </div>
                        <div class="form-row d-none">
                            <div class="col-lg-12">
                                <table>
                                    <tr>
                                        <td class="label">Street address</td>
                                        <td class="slimField"><input class="field" id="street_number" name="add_number" disabled="true"></td>
                                        <td class="wideField" colspan="2"><input class="field" id="route" name="add_street" disabled="true"></td>
                                    </tr>
                                    <tr>
                                        <td class="label">City</td>
                                        <td class="wideField" colspan="3"><input class="field" id="locality" disabled="true"></td>
                                    </tr>
                                    <tr>
                                        <td class="label">State</td>
                                        <td class="slimField"><input class="field" id="administrative_area_level_1" disabled="true"></td>
                                        <td class="label">Zip code</td>
                                        <td class="wideField"><input class="field" id="postal_code" name="postal_code" disabled="true"></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Country</td>
                                        <td class="wideField" colspan="3"><input class="field" id="country" disabled="true"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label>What is your email?</label>
                            <input type="email" name="email" class="form-control" placeholder="johndoe@email.com">
                        </div>
                        <div class="form-group col-12">
                            <label>Upload Image</label>
                            <div class="custom-file">
                                <input type="file" name="filesToUpload[]" class="custom-file-input" id="filesToUpload" multiple>
                                <label class="custom-file-label" for="customFile">Choose file...</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-row" id="image-preview"></div>
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
    </div>
</main>

<script>
    $("#type").change(function() {
        $("#subtype").load("getter.php?choice=" + encodeURI($("#type").val()));
    });

</script>

<script>
    function handleFileSelect(evt) {
        var files = evt.target.files;
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {
            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    var div = document.createElement('div');
                    div.setAttribute("class", "col-3");
                    div.innerHTML = [
                        '<img class="img-thumbnail" src="',
                        e.target.result,
                        '" title="', escape(theFile.name),
                        '"/>'
                    ].join('');
                    document.getElementById('image-preview').insertBefore(div, null);
                };
            })(f);
            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('filesToUpload').addEventListener('change', handleFileSelect, false);

</script>

<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
    
    // Normally geolocate could be used to find the user's location, it has been edited to bias a 10km radius around the center of Buffalo as defined by Google Maps, 42.8864,-78.8783
    
      function geolocate() {
            var geolocation = {
              lat: 42.8864,
              lng: -78.8783
            };
          // Radius is set in meters
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: 10000
            });
            autocomplete.setBounds(circle.getBounds());
          };
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1hgyqHWtrkaolwztdX5G_nc2nFdFgyis&libraries=places&callback=initAutocomplete" async defer>
</script>
<?php include "inc/footer.php"?>
