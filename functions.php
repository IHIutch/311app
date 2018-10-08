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
    $address = $_POST['address'];
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
    return array($address, $lng, $lat);
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
        
        $array = geocoder();
        $address = $array[0];
        $lng = $array[1];
        $lat = $array[2];
        
        $type = mysqli_real_escape_string($connection, $type);
        $subtype = mysqli_real_escape_string($connection, $subtype);
        $comments = mysqli_real_escape_string($connection, $comments);
        
        $query = "INSERT INTO reports(submission_date, type, subtype, lat, lng, email, comments)";
        $query .= " VALUES ('$submission_date', '$type', '$subtype', '$lat', '$lng', '$email', '$comments')"; 

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
    
    $query = "SELECT lat, lng, type FROM reports";
    
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
                'type' => $row['type']
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



function test(){
    header('Content-Type: application/json');
    $a = getCurrentData();
    
    echo json_encode($a, JSON_PRETTY_PRINT);
};

//test();


?>
