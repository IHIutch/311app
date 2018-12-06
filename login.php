<?php include "inc/header.php"?>

<div class="container">
    <div class="row">
        <div class="col-6 offset-3">
            <form method="post" action="verify.php" name="login" id="login" autocomplete="off">
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Your Password" required>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" id="register" value="Log In" />
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php"?>
