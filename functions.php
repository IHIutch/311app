<?php
include __DIR__.'/lib/db.php';

date_default_timezone_set('America/New_York');

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

        if(!empty($_POST['email'])){
            $email = $_POST['email'];
        }else{
            $email = 'anonymous';
        };
                
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
            return false;
        } else{
            return true;
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
    
    $query = "SELECT lat, lng, subject, subtype, street_name, street_num, id FROM reports";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
        // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){
        
    $street_name = str_ireplace(
        array("boulevard","avenue", "street", "road", "terrace", "highway"), 
        array("Blvd", "Ave", "St", "Rd", "Terr", "Hwy"),
        $row['street_name']);
        
        $lnglat = array($row['lng'], $row['lat']);
        
        $points[] = array(
            'type' => 'Feature',
            'properties' => array(
                'subtype' => $row['subtype'],
                'subject' => $row['subject'],
                'id' => $row['id'],
                'address' => $row['street_num'] . ' ' . $street_name,
                'coords' => $row['lat'] . ', ' . $row['lng'],
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

function getSinglePoint(){
    
    $id = getIdFromURL();
    
    global $connection;
    
    $query = "SELECT lat, lng, subject, type FROM reports WHERE id = '$id'";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
        // Puts Stop Data into an array
    while ($row = mysqli_fetch_assoc($result)){
        
        $lnglat = array($row['lng'], $row['lat']);
        
        $point = array(
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
        'type'=> 'Feature',
        'features' => $point,
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
                $insert = $connection->query("INSERT INTO images (file_name, uploaded_on, ticket_id) VALUES $insertValuesSQL");
                if(!$insert){
                    $errorUpload = !empty($errorUpload)?'Upload Error: '.$errorUpload:'';
                    $errorUploadType = !empty($errorUploadType)?'File Type Error: '.$errorUploadType:'';
                    $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
                    
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
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


function login(){
    
    session_start();
    global $connection;

};

function doesUserExist($email){
    
    global $connection;
    
    if($email != ''){
        $email = mysqli_real_escape_string($connection, $email);
        $result = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email'");

        if(mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        } 
    }else{
        exit();
    }
}

function createNewUser(){
        
    global $connection;
    
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users(email, password)";
    $query .= "VALUES('$email', '$password')";

    $result = mysqli_query($connection, $query);
    
    return $result;
}

function loginVerify(){
    if(isset($_POST['submit'])){
        global $connection;

        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
                
        $result = mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");

        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result);
            if(password_verify($password, $row['password'])){
                session_start(); 
                $_SESSION['email'] = $row['email'];  
                $_SESSION['admin'] = $row['admin'];
                $_SESSION['logged'] = TRUE; 
                header("Location: profile.php"); // Modify to go to the page you would like 
                exit; 
            }else{ 
                header("Location: login.php"); 
                exit;
            }
        }else{ 
            header("Location: login.php"); 
            exit; 
        } 
    }else{    //If the form button wasn't submitted go to the index page, or login page 
        header("Location: login.php");     
        exit; 
    }
}

function showUserData($email){
            
    // Opens a connection to a MySQL server
    global $connection;
    
    // Select data from database
    $query = "SELECT * FROM reports WHERE email = '$email' ORDER BY id DESC";
    
    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
    if($result->num_rows > 0){

        while ($row = mysqli_fetch_assoc($result)){       
            $data[] = $row;
        };

        return $data;
    }else{
        exit;
    }
}

function uploadInfo($create_row,$upload_image,$last_id){
    if ($create_row && $upload_image){
        
        $emailType = 'reportCreated';
        sendEmail($emailType, $last_id);
        
        header("Location: report.php?report_id=".$last_id);  
    }else{
        die('Something went wrong');
    }
}

function sendEmail($emailType, $emailData){
    global $connection;
    $mgKey = env('MAILGUN');

    if($emailType == 'reportCreated'){
        
        $query = "SELECT id, email, street_num, street_name, type, subtype, zip FROM reports WHERE id = '$emailData'";
        $result = mysqli_query($connection, $query);
        
        while ($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        
        if($data['email'] != ''){
            include 'emails/submit-ticket.php';
        }
    }else if($emailType == 'statusUpdate'){
        
        $query = "SELECT id, email, street_num, street_name, type, subtype, zip, status FROM reports WHERE id = '$emailData'";
        $result = mysqli_query($connection, $query);
        
        while ($row = mysqli_fetch_assoc($result)){
            $data = $row;
        }
        
        if($data['email'] != ''){
            include 'emails/status-update.php';
        }
    }elseif($emailType == 'passwordReset'){
        $email = $emailData['email'];
        $token = $emailData['token'];
        
        include 'emails/reset-pw.php';
    }
}

function updateStatus($report_id, $status){
    global $connection;
    
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $report_id = mysqli_real_escape_string($connection, $_GET['report_id']);
        
    $query = "UPDATE reports SET status = '$status' WHERE id='$report_id'";
    $result = mysqli_query($connection, $query);
    
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }else{
        $emailType = 'statusUpdate';
        sendEmail($emailType, $report_id);
        header("Location: report.php?report_id=" . $report_id);
        exit;
    }
}

function pw_reset(){
    global $connection;
    
    $email = $_POST['email'];
    
    // Create tokens
    $token = sha1(time() . mt_rand(1,99999999));

    // Token expiration
    $expires = new DateTime('NOW');
    $expires->add(new DateInterval('PT1H')); // 1 hour
    $expires = $expires->format('U');
            
    $query = "UPDATE users SET token = '$token', expires = '$expires' WHERE email='$email'";
    $result = mysqli_query($connection, $query);
    
    $emailData = array('email' => $email, 'token' => $token);
    
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }else{
        $emailType = 'passwordReset';
        sendEmail($emailType, $emailData);
    } 
}

function updatePassword(){
    if(isset($_POST['password'])){
        global $connection;
        
        $token = mysqli_real_escape_string($connection, $_GET['code']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
    
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "UPDATE users SET password = '$password' WHERE token = '$token'";
        
        $result = mysqli_query($connection, $query);

        if(!$result){
            die("Password update didn't work. Click the link in your email and try again");
        }else{
            return true;
        } 
    }else{
        return false;
    }            
}

function submitFeedback(){
    if(isset($_POST['message'])){
        global $connection;
        
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $message = mysqli_real_escape_string($connection, $_POST['message']);
            
        $query = "INSERT INTO feedback(email, message) VALUES ('$email', '$message') ";
        
        $result = mysqli_query($connection, $query);
        
        
        
        if(!$result){
            exit;
        }else{
            return true;
        }
    }
}

//function uploadNewData(){
//    global $connection;
//    
//    $query = "SELECT * FROM temp";
//    
//    $result = mysqli_query($connection, $query);
//
//    $status_arr = array('under review', 'assigned', 'scheduled', 'submitted');
//    
//    while($row = mysqli_fetch_assoc($result)){
//            
//        $open_date = DateTime::createFromFormat('n/j/y G:i',$row['open_date']);
//        $open_date = $open_date->format('Y-m-d H:i');
//        
//        
//        if(is_null($row['closed_date'])){
//            $closed_date = '';
//        }else{
//            $closed_date = DateTime::createFromFormat('n/j/y G:i',$row['closed_date']);
//            $closed_date = $closed_date->format('Y-m-d H:i');
//        }
//        
////        print_r(DateTime::getLastErrors());
//
//        if($row['status'] == 'Open'){
//            $status = $status_arr[array_rand($status_arr, 1)];
//        }else{
//            $status = 'completed';
//        }
//        
//        $subject = $row['subject'];
//        $reason = $row['reason'];
//        $type = str_replace(" (Req_Serv)", "", $row['type']);
//        $street_num = $row['street_num'];
//        $street_name = ucwords(strtolower($row['street_name']));
//        $zip = $row['zip'];
//        $lat = $row['lat'];
//        $lon = $row['lon'];
//
//        $query_1 = "INSERT INTO reports(submission_date, closed_date, subject, type, subtype, lat, lng, street_num, street_name, zip, status)";
//        $query_1 .= " VALUES ('$open_date', '$closed_date', '$subject', '$reason', '$type', '$lat', '$lon', '$street_num', '$street_name', '$zip', '$status')";
//        
//        $result_1 = mysqli_query($connection, $query_1);
//        
//        if(!$result_1){
//            die('Query failed.' . mysqli_error($connection));
//        }
//    } 
//
//}

?>
