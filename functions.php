<?php include "../lib/db.php"; ?>
<?php

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
    global $connection;
    if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $type = $_POST['type'];
        
        $array = geocoder();
        $address = $array[0];
        $lng = $array[1];
        $lat = $array[2];
        
        $name = mysqli_real_escape_string($connection, $name);
        $type = mysqli_real_escape_string($connection, $type);
        
        $query = "INSERT INTO markers(name, address, lng, lat, type)";
        $query .= " VALUES ('$name', '$address', '$lng', '$lat', '$type')"; 

        $result = mysqli_query($connection, $query);

        if(!$result){
            die('Query failed.' . mysqli_error($connection));
        } else{
            echo "Record created!";
        }
    }
}

function readRows(){
    global $connection;
    $query = "SELECT * FROM markers";
    $result = mysqli_query($connection, $query);
    
    if(!$result){
        die('Query failed.' . mysqli_error($connection));
    } 
       while($row = mysqli_fetch_assoc($result)){
           ?>
           <pre>
           <?php
           print_r($row);
           ?>
           </pre>
           <?php
       }
}

function updateTable(){
    if(isset($_POST['submit'])){
        global $connection;

        $name = $_POST['name'];
        $address = $_POST['address'];
        $lng = $_POST['lng'];
        $lat = $_POST['lat'];
        $type = $_POST['type'];
        $id = $_POST['id'];

        $query = "UPDATE map_locations SET ";
        $query .= "name = '$name', ";
        $query .= "address = '$address' ";
        $query .= "lng = '$lng', ";
        $query .= "lat = '$lat' ";
        $query .= "type = '$type' ";
        $query .= "WHERE id = $id ";

        $result = mysqli_query($connection, $query);
        if(!$result){
           die("Query Failed" . mysqli_error($connection));
        } else{
            echo "Record Updated!";
        }
    }
}


function deleteRows(){
    if(isset($_POST['submit'])){
        global $connection;

        $name = $_POST['name'];
        $address = $_POST['address'];
        $lng = $_POST['lng'];
        $lat = $_POST['lat'];
        $type = $_POST['type'];
        $id = $_POST['id'];

        $query = "DELETE FROM map_locations ";
        $query .= "WHERE id = $id ";

        $result = mysqli_query($connection, $query);
        if(!$result){
           die("Query Failed" . mysqli_error($connection));
        } else{
            echo "Record deleted!";
        }
    }
}
?>