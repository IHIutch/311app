<?php include "inc/header.php"?>

<?php $info = getInfo();
header('Content-Type: application/json');
echo json_encode($info, JSON_PRETTY_PRINT);?>


<? include "inc/footer.php"?>