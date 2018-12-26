<?php include "inc/header.php";?>

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
                <form action="thank-you.php" method="post" enctype="multipart/form-data" id="myForm">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>What is the type?</label>
                            <select class="form-control" name="type" id="type" required>
                                <option value="" selected>Please Select</option>
                                <?php 
                                    $types = getIssueTypes();
                                    foreach($types as $t){
                                        echo "<option>$t</option>";
                                    };
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the subtype?</label>
                            <select class="form-control" name="subtype" id="subtype" required>
                                <option value="" selected>First select a type</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>What is the location of the issue?</label>
                            <input type="search" name="search" class="form-control" id="autocomplete" placeholder="123 Main Street..." required>
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
                            <div class="custom-control custom-checkbox mb-2 ">
                                <input type="checkbox" class="custom-control-input" id="anonymous">
                                <label class="custom-control-label" for="anonymous">I'd prefer to stay anonymous</label>
                            </div>
                            <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@email.com" required>
                        </div>
                        <div class="form-group col-12">
                            <label>Upload Image</label>
                            <!-- The file input field used as target for the file upload widget -->
                            <div class="custom-file mb-3">
                                <input type="file" name="filesToUpload[]" class="custom-file-input" id="image-upload" accept="image/*" multiple>
                                <label class="custom-file-label" for="customFile">Choose file(s)...</label>
                            </div>
                            <div class="form-row mb-3" id="image-preview"></div>
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
        $("#subtype").load("getter.php?choice=" + encodeURIComponent($("#type").val()));
    });

    $("#anonymous").change(function() {
        if ($("#anonymous").is(":checked")) {
            $('#email').prop('disabled', true);
        } else {
            $('#email').prop('disabled', false);
        }
    });

</script>

<!--
<script>
    var selDiv = "";
    var storedFiles = [];

    $("#image-upload").on("change", handleFileSelect);

    selDiv = $("#image-preview");

    $("body").on("click", ".clear", removeFile);
    var myForm = document.getElementById('myForm');

    function handleFileSelect(e) {
        
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);
        filesArr.forEach(function(f) {

            if (!f.type.match("image.*")) {
                return;
            }
            storedFiles.push(f);

            var reader = new FileReader();
            reader.onload = function(e) {
                var clearButton = '<div class="btn btn-secondary clear">Clear</div>';
                var preview = "<div class='col-3'><img class='img-thumbnail' src=\"" + e.target.result + "\" data-file='" + f.name + "'>" + f.name + clearButton + "</div>";
                selDiv.append(preview);
            }
            
            reader.readAsDataURL(f);
        });
    }
    
    function getInfo() {
        alert($(this).prev().data("file"));
    }

    function removeFile(e) {

        var file = $(this).prev().data("file");
                
        for (var i = 0; i < storedFiles.length; i++) {
            if (storedFiles[i].name === file) {
                storedFiles.splice(i, 1);
                break;
            }
        }
        $(this).parent().remove();
        
        var data = new FormData();
        for(var i=0, len=storedFiles.length; i<len; i++) {
			data.append('filesToUpload[]', storedFiles[i]);	
		}
        
        console.log(data.getAll('filesToUpload[]'));
    }


	function handleForm(e) {
		e.preventDefault();
		var data = new FormData();
		
		for(var i=0, len=storedFiles.length; i<len; i++) {
			data.append('filesToUpload[]', storedFiles[i]);	
		}
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'thank-you.php', true);
		
		xhr.onload = function(e) {
			if(this.status == 200) {
				console.log(e.currentTarget.responseText);	
				alert(e.currentTarget.responseText + ' items uploaded.');
			}
		}
		
		xhr.send(data);
	}

</script>
-->

<script>
    function previewImages() {

        var $preview = $('#image-preview').empty();
        if (this.files) $.each(this.files, readAndPreview);

        function readAndPreview(i, file) {

            if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
                return alert(file.name + " is not an image");
            } // else...

            var reader = new FileReader();

            $(reader).on("load", function() {

                //                $preview.append('<div id="test" class="col-3"></div>');
                $preview.append($('<div/>', {
                        class: 'col-3'
                    })
                    .append($('<img/>', {
                        src: this.result,
                        class: 'img-thumbnail'
                    })));
            });
            reader.readAsDataURL(file);
        }
    }

    $('#image-upload').on("change", previewImages);

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
            /** @type {!HTMLInputElement} */
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });

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
