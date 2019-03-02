<?php

$app->get('/', function ($request, $response) {
    
    return $this->view->render($response, 'create.php', ['router' => $this->router]);
});

$app->post('/', function ($request, $response) {
    $new_report = ORM::for_table('reports')->create();
    $new_report->type = $request->getParam('type');
    $new_report->subtype = $request->getParam('subtype');
    $new_report->street_name = $request->getParam('street_name');
    $new_report->street_num = $request->getParam('street_num');
    $new_report->email = $request->getParam('email');
    $new_report->comments = $request->getParam('comments');
    $new_report->set_expr('submission_date', 'NOW()');
    
    $images = [];
    for ($i=0; $i<count($_FILES['image']['name']);$i++) {
        if (empty($_FILES['image']['name'][$i])) continue;
        $images[] = s3_image_upload($_FILES['image']['tmp_name'][$i], $_FILES['image']['name'][$i]);
    }
    $new_report->set('image', json_encode($images));
    $new_report->save();
    
    $email = $request->getParam('email');
    $details = $request->getParsedBody();
    
    $id = array('id' => $new_report->id());
    $details += $id;
    
    mail_submit($email, $details);
//    print_r($details);
    
//    echo $details['']
    return $response->withRedirect('/report/'.$new_report->id());
})->setName('submit_data');