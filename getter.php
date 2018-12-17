<?php 
    include __DIR__.'/lib/db.php';
    
    global $connection;
    
    $choice = mysqli_real_escape_string($connection, $_GET['choice']);
	$query = "SELECT * FROM issue_types WHERE type = '$choice'";

    //Return error if connection fails
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error($connection));
    }
    
    while ($row = mysqli_fetch_assoc($result)){
        if($row['subtype']){
           echo "<option>" . $row['subtype'] . "</option>"; 
        }
        else{
            echo "something went wrong";
        }
    }
?>
