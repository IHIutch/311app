<?php
    require __DIR__.'/../vendor/autoload.php';
    use Mailgun\Mailgun;

    # Instantiate the client.
    $key = env('MAILGUN');
    $mgClient = new Mailgun($key);
    $domain = "beta.buffalo311.org";

    $html = file_get_contents(__DIR__.'/templates/reset-pw.html');

    $link = 'https://beta.buffalo311.org/reset.php?code='.$token;
    $html = str_replace("#link#",$link,$html);
    $toEmail = '<'.$email.'>';

//echo $html;


    # Make the call to the client.
    $result = $mgClient->sendMessage($domain, array(
        'from'    => 'Buffalo 311 <info@beta.buffalo311.org>',
        'to'      => $toEmail,
        'subject' => 'Reset Your Password',
        'html'    => $html
    ));
?>