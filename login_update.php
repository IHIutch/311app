<?php include "db.php";?>
<?php include "functions.php";?>

<?php updateTable();?>
<?php include "inc/header.php"?>
   
   <div class="container">
       <div class="col-xs-6">
         <h1 class="text-center">Update</h1>
          <form action="login_update.php" method="post">
               <div class="form-group">
                  <label for="name">Name</label>
                   <input type="text" name="name" class="form-control">
               </div>
               <div class="form-group">
                  <label for="address">Address</label>
                   <input type="text" name="address" class="form-control">
               </div>
               <div class="form-group">
                  <label for="lng">Longitude</label>
                   <input type="text" name="lng" class="form-control">
               </div>
               <div class="form-group">
                  <label for="lat">Latitude</label>
                   <input type="text" name="lat" class="form-control">
               </div>
               <div class="form-group">
                  <label for="type">Type</label>
                   <input type="text" name="type" class="form-control">
               </div>
               <div class="form-group">
                
                   <select name="id" id="">
                       <?php showAllData(); ?>
                   </select>
                   
               </div>
               
               <input class="btn btn-primary" type="submit" name="submit" value="UPDATE">
           </form> 
       </div>
   </div>
    
<?php include "inc/footer.php"?>
