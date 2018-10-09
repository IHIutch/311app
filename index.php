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
<main role="main" class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h1">Submit an Issue</h1>
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
        <div class="col-12 col-md-8 offset-md-2">
            <div class="p-4 bg-white rounded shadow-sm mb-4">
                <form action="thank-you.php" method="post" enctype="multipart/form-data">
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
<?php include "inc/footer.php"?>
