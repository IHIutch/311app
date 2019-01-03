<?php include "inc/header.php";

if(isset($_POST['email'])){
    $userExists = doesUserExist($_POST['email']);
}
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 mt-5">

            <?php 
            if(isset($userExists) && $userExists){
                pw_reset(); ?>

            <p>A link to create a new password has been sent to your email.</p>
            
            <?php }else{ ?>
            
            <h1>Forgot Your Password?</h1>
            <p>That's okay, we'll send you an email so you can reset it.</p>
            <form method="post" action="forgot.php" name="login" id="login" autocomplete="off">
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" id="reset" value="Reset Password" />
            </form>
            
            <?php };?>
            <div class="text-center">
                <a class="small" href="/login.php">Go Back to Login</a>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php";?>
