<?php
    require __DIR__.'/../vendor/autoload.php';
    use Mailgun\Mailgun;

    # Instantiate the client.
    $domain = "beta.buffalo311.org";

    $html = file_get_contents(__DIR__.'/templates/submit-ticket.html');
    $html = str_replace("#id#",$data['id'],$html);
    $html = str_replace("#type#",$data['type'],$html);
    $html = str_replace("#subtype#",$data['subtype'],$html);
    $html = str_replace("#street_num#",$data['street_num'],$html);
    $html = str_replace("#street_name#",$data['street_name'],$html);
    $html = str_replace("#zip#",$data['zip'],$html);   
    $link = 'https://beta.buffalo311.org/report.php?report_id='.$data['id'];
    $html = str_replace("#link#",$link,$html);
    $toEmail = '<'.$data['email'].'>';


    # Make the call to the client.
    $result = $mgClient->sendMessage($domain, array(
        'from'    => 'Buffalo 311 <info@beta.buffalo311.org>',
        'to'      => $toEmail,
        'subject' => 'Thank You for Your Submission',
        'html'    => $html
    ));
?>
