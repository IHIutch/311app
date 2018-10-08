<?php include "inc/header.php"?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mt-3">
            <?php $info = getInfo();
            $images = getImages();?>

            <?php
                foreach ($info as $k => $v){
                    echo "<p><strong>$k</strong>: $v</p>";
                };
            ?>
        </div>
    </div>
    <div class="row">
        <?php 
            foreach($images as $key){
                foreach($key as $k => $v){
                    echo '<div class="col-3"><img src="uploads/'.$v.'" class="w-100 img-thumbnail"></div>';
                }
            };
        ?>
    </div>
</div>

<?php include "inc/footer.php"?>
