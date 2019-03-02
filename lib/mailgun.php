<?php

use Mailgun\Mailgun;

function mail_submit($to, $details){
    
    $mg = Mailgun::create(getenv('MAILGUN')); // For US servers
    
    $html = file_get_contents(__DIR__.'/../templates/emails/submit-ticket.html');
    $html = str_replace('#id#',$details['id'],$html);
    $html = str_replace('#type#',$details['type'],$html);
    $html = str_replace('#subtype#',$details['subtype'],$html);
    $html = str_replace('#street_num#',$details['street_num'],$html);
    $html = str_replace('#street_name#',$details['street_name'],$html);
    $html = str_replace('#zip#',$details['postal_code'],$html);   
    $link = 'https://'.$_SERVER['SERVER_NAME'].'/report/'.$details['id'];
    $html = str_replace('#link#',$link,$html);
    
    $mg->messages()->send('beta.buffalo311.org', [
      'from'       => 'Buffalo 311 <info@beta.buffalo311.org>',
      'to'         => $to,
      'subject'    => 'Thank You for Your Submission',
      'html'       => $html
    ]); 
}
