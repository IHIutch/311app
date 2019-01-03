<?php 
include "inc/header.php"; 
$token = $_GET['code'];

?>

<div class="container">
    <div class="row">
    <div class="col-12 col-md-6 offset-md-3 mt-5">
       <?php if(updatePassword()){ ?>
        <p>Your password hase been updated!</p>
            <?php }else{ ?>
            <h1>Reset Your Password</h1>
            <p>Enter a new password below</p>

            <form method="post" action="reset.php?code=<?php echo $token;?>" name="login" id="login" autocomplete="off">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Your Password" required>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" id="register" value="Reset Password" />
            </form>
            <?php }; ?>
            <div class="text-center">
                <a class="small" href="/forgot.php">Go Back to Login</a>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php";?>