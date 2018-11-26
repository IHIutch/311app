<?php
include __DIR__.'/lib/db.php';

function showAllData(){
    global $connection;
    $query = "SELECT * FROM map_locations";
    
    $result = mysqli_query($connection, $query);
    
    if(!$result){
        die('Query failed.' . mysqli_error($connection));
    }

    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
      echo "<option value='$id'>$id</option>";

    }   
}

function geocoder(){
    global $connection;
    $add_number = $_POST['add_number'];
    $add_street = $_POST['add_street'];
    $address = $add_number . " " . $add_street;
    $address = mysqli_real_escape_string($connection, $address);
    $encodeAdd = urlencode($address);

    $apikey = "AIzaSyCoaxEFz926RAn5JG8NvrRK0KQ9xI8g_e4"; 
    $geourl = "https://maps.googleapis.com/maps/api/geocode/xml?address=$encodeAdd,+Buffalo,+NY&key=$apikey"; 

    /* Create cUrl object to grab XML content using $geourl */ 
    $c = curl_init(); 
    curl_setopt($c, CURLOPT_URL, $geourl); 
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
    $xmlContent = trim(curl_exec($c)); 
    curl_close($c); 
    /* Create SimpleXML object from XML Content*/
    $xmlObject = simplexml_load_string($xmlContent); 
    /* Print out all of the XML Object*/ 
    $localObject = $xmlObject->result->geometry->location; 

    $lng = ($localObject->lng);
    $lat = ($localObject->lat);
    return array($add_number, $add_street, $lng, $lat);
}

function createRows(){
    
    date_default_timezone_set("America/New_York");
    global $connection;
    
    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $type = $_POST['type'];
        $subtype = $_POST['subtype'];
        $submission_date = date("Y-m-d H:i:s");
        $comments = $_POST['comments'];
        
        $subject = getSubject($type);
        
        $geo_array = geocoder();
        $add_number = $geo_array[0];
        $add_street = $geo_array[1];
        $lng = $geo_array[2];
        $lat = $geo_array[3];
        $postal_code = $_POST['postal_code'];
        
        $type = mysqli_real_escape_string($connection, $type);
        $subtype = mysqli_real_escape_string($connection, $subtype);
        $comments = mysqli_real_escape_string($connection, $comments);
        
        $query = "INSERT INTO reports(submission_date, subject, type, subtype, lat, lng, email, comments, street_num, street_name, zip)";
        $query .= " VALUES ('$submission_date', '$subject', '$type', '$subtype', '$lat', '$lng', '$email', '$comments', '$add_number', '$add_street', '$postal_code')"; 

        $result = mysqli_query($connection, $query);

        if(!$result){
            die('Query failed.' . mysqli_error($connection));
        } else{
            echo "Record created!";
        }
    }
}

function getIdFromURL(){
    $id = $_GET["report_id"];
    return $id;
};

function getInfo(){
        
    // Opens a connection to a MySQL server
    global $connection;
    $id = getIdFromURL();
    
    // Select data from database
    $query = "SELECT * FROM reports
    WHERE id = ". $id ."";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }

    // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){       
        $data = $row;
    };
    return $data;
};

function getImages(){
        
    // Opens a connection to a MySQL server
    global $connection;
    $id = getIdFromURL();
    
    // Select data from database
    $query = "SELECT file_name FROM images
    WHERE ticket_id = ". $id ."";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }

    $data = array();
    // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){       
        $data[] = $row;
    };
    if($data){
        return $data;
    }
};

function showTable(){
        
    // Opens a connection to a MySQL server
    global $connection;
    
    // Select data from database
    $query = "SELECT * FROM reports ORDER BY id DESC";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }

    // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){       
        $data[] = $row;
    };
    return $data;
};

function getPoints(){
    
    global $connection;
    
    $query = "SELECT lat, lng, subject, type FROM reports";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
        // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){
        
        $lnglat = array();
        $lnglat = array($row['lng'], $row['lat']);
        
        $points[] = array(
            'type' => 'Feature',
            'properties' => array(
                'type' => $row['type'],
                'subject' => $row['subject']
            ),
            'geometry' => array(
                'type' => 'Point',
                'coordinates' => $lnglat
            )
        );
    };
        
    $array = array(    
        'type'=> 'FeatureCollection',
        'features' => $points,
    );
    
    return $array;
};

function uploadImage(){
    
    global $connection;

    if(isset($_POST['submit'])){
    // File upload configuration
    $targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg','gif');
    $last_id = mysqli_insert_id($connection);

    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    if(!empty(array_filter($_FILES['filesToUpload']['name']))){
        foreach($_FILES['filesToUpload']['name'] as $key=>$val){
            // File upload path
            $fileName = basename($_FILES['filesToUpload']['name'][$key]);
            
            //Rename file to match ticket_id and array position
            $ext = explode('.', $_FILES['filesToUpload']['name'][$key]);
            $ext = end($ext);
            $fileRename = $last_id.'-'.$key.'.';
            $fileName = $fileRename . $ext;
            
            $targetFilePath = $targetDir . $fileName;
                        
            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$key], $targetFilePath)){
                    // Image db insert sql
                    $insertValuesSQL .= "('".$fileName."', NOW(), $last_id),";
                }else{
                    $errorUpload .= $_FILES['filesToUpload']['name'][$key].', ';
                }
            }else{
                $errorUploadType .= $_FILES['filesToUpload']['name'][$key].', ';
            }
        }
        
        if(!empty($insertValuesSQL)){
            $insertValuesSQL = trim($insertValuesSQL,',');
            // Insert image file name into database
            $last_id = mysqli_insert_id($connection);
            $insert = $connection->query("INSERT INTO images (file_name, uploaded_on, ticket_id) VALUES $insertValuesSQL");
            if($insert){
                $errorUpload = !empty($errorUpload)?'Upload Error: '.$errorUpload:'';
                $errorUploadType = !empty($errorUploadType)?'File Type Error: '.$errorUploadType:'';
                $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
                $statusMsg = "Files are uploaded successfully.".$errorMsg;
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }
    
    // Display status message
    echo $statusMsg;
    }
}

function getCurrentData(){
    
    global $connection;
    
    $query = "SELECT latitude, longitude, reason FROM current";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
        // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){
        
        $lnglat = array();
        $lnglat = array($row['longitude'], $row['latitude']);
        
        $points[] = array(
                'type' => 'Feature',
                'properties' => array(
                    'type' => $row['reason']
                ),
                'geometry' => array(
                    'type' => 'Point',
                    'coordinates' => $lnglat
                )
            );
    };
        
        $array = array(    
            'type'=> 'FeatureCollection',
            'features' => $points,
        );
    
    return $array;
};

function getIssueTypes(){
    global $connection;
    
    $query = "SELECT DISTINCT type FROM issue_types";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
        // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){
        $array[] = $row['type'];
    };
    
    return $array;
}


function getSubject($type){
    if ($type == 'Sanitation'
        || $type == 'Engineering - Traffic'
        || $type == 'Engineering - Street Repairs'
        || $type == 'Streets/Sanitation'
        || $type == 'Streets'
        || $type == 'Rodent Control'
        || $type == 'Personnel'
        || $type == 'City Parks'
        || $type == 'Forestry'
        || $type == 'Buildings Division'
        || $type == 'Animal Shelter'
        || $type == 'Harbor Master'
        || $type == 'Telecommunications'){
        return "Dept of Public Works";
    }
    elseif ($type == 'Real Estate'
           || $type == 'Administration'
           || $type == 'OSP'){
        return "Office of Strategic Planning";
    }
    elseif ($type == 'Citizen Services - Quick Response Teams'
           || $type == 'Citizens Services - Clean City'
           || $type == 'Citizen Services - Graffiti'
           || $type == 'Citizen Services - Save Our Streets'){
        return "Office of the Mayor";
    }
    elseif ($type == 'Housing'){
        return "DPIS";
    }
    elseif ($type == 'National Grid'
           || $type == 'Buffalo Sewer Authority'
           || $type == 'Buffalo Water Authority'){
        return "Utilities";
    }
    elseif ($type == 'HR'){
        return "Human Resources";
    }
    elseif ($type == 'Freedom of Information'
           || $type == 'Adjudication - Ordinance Violation'){
        return "Dept of Law";
    }
    elseif ($type == 'Taxation'
           || $type == 'Assessment & Taxation'){
        return "Assessment & Taxation";
    }
    elseif ($type == 'BFD'){
        return "Buffalo Fire Department";
    }
    elseif ($type == 'Community Based Orgs'
           || $type == 'Youth Bureau'){
        return "Community Services & Rec. Program";
    }
    elseif ($type == 'BMHA'){
        return "Buffalo Municipal Housing Authority";
    }
    elseif ($type == 'Police'){
        return "Buffalo Police Department";
    }
    elseif ($type == 'Parking Violations Bureau'
           || $type == 'Moving Violations'){
        return "Dept of Parking";
    }
    elseif ($type == 'City Clerk Issue'
           || $type == 'Licenses'){
        return "City Clerk";
    }
    else {
        return "Miscellaneous";
    }
}

function test(){
    header('Content-Type: application/json');
    $a = getCurrentData();
    
    echo json_encode($a, JSON_PRETTY_PRINT);
};

//test();


?>
