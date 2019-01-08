<?php include "inc/header.php";?>

<div class="container mt-4">
    <?php if(submitFeedback()){ ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>Your message has been sent, thank you!</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 mb-3">
            <h1>Give your Feedback</h1>
            <p>If you have anything to say about this app, good or bad, or any thoughts or suggestions, I'd love to read them. Thanks for checking out the site!</p>
        </div>
        <div class="col-12 col-md-6 offset-md-3">
            <form action="feedback.php" method="post">
                <div class="form-group">
                    <label for="email">Your Email (Optional)</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="message">Your message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your feedback or comments..." maxlength="2000" required></textarea>
                </div>
                <div class="text-center">
                    <input class="btn btn-primary" id="submit" type="submit" name="submit" value="Send Your Message">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "inc/footer.php";?>
