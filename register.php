<?php include "inc/header.php";

if(isset($_POST['email'])){
    $userExists = doesUserExist($_POST['email']);
};
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 mt-5">
            
            <?php if(isset($_POST['email']) && !$userExists){
                    if(createNewUser()){ ?>
                <div class="card p-4 mt-5">
                    <h1>Success</h1>
                    <p>Your account was successfully created. Please <a href="login.php">click here to login</a>.</p>
                </div>
            <?php } else{ ?>
                <div class="card p-4 mt-5">
                    <h1>Error</h1>
                    <p>Sorry, your registration failed. Please go back and try again.</p>
                </div>
            <?php }
            }else{ ?>

            <h1>Register</h1>
            <p>Please enter your details below to register.</p>

            <form method="post" action="register.php" name="registerform" id="registerform" autocomplete="off">
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                    <?php if(isset($_POST['email']) && $userExists){ ?>
                    <small id="emailHelp" class="form-text text-danger">That email is already in use.</small>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Your Password" required>
                </div>
                <input class="btn btn-primary" type="submit" name="register" id="register" value="Register" />
            </form>

            <?php } ?>
        </div>
    </div>
</div>

<?php include "inc/footer.php"?>
