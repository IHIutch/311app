<?php
//    include_once './config.php';

    require __DIR__.'/../vendor/autoload.php';
    use Mailgun\Mailgun;

    # Instantiate the client.
    $mgClient = new Mailgun('1f5be2998bf054da6aa7092b9ee24965-b3780ee5-df856c2a');
    $domain = "sandboxde15062f10eb4431a0ebb704aa84ad66.mailgun.org";

    # Make the call to the client.
    $result = $mgClient->sendMessage($domain, array(
        'from'    => 'Buffalo 311 <mailgun@sandboxde15062f10eb4431a0ebb704aa84ad66.mailgun.org>',
        'to'      => '<jbhutch01@gmail.com>',
        'subject' => 'Thank You for Your Submission',
        'text'    => $_POST['add_number'] . ' ' . $_POST['add_street'],
        'html'    => '<html>This is a test</html>'
    ));
?>