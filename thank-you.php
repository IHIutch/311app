<?php 
if(empty($_POST['submit'])){ 
    header("Location: index.php"); 
    exit; 
};

include "functions.php";

$create_row = createRows(); 
$last_id = mysqli_insert_id($connection);
$upload_image = uploadImage(); 

//uploadInfo($create_row, $upload_image, $last_id)
?>