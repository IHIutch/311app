<?php include "inc/header.php"?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 mt-3">
            <?php $info = getInfo();?>
            <?php
                foreach ($info as $k => $v){
                    echo "<p><strong>$k</strong>: $v</p>";
                }
            ?>
        </div>
    </div>
</div>

<? include "inc/footer.php"?>
