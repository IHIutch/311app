<?php 
if(empty($_POST['submit'])){ 
    header("Location: index.php"); 
    exit; 
};

include "functions.php";

createRows(); 
uploadImage(); 
    
$last_id = mysqli_insert_id($connection);
header("Location: report.php?report_id=".$last_id); 
?>