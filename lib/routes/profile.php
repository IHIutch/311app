<?php

$app->get('/profile/{uid}', function ($request, $response, $args) {
        
    $reports = ORM::for_table('reports')
        ->select_many('reports.id', 'reports.submission_date', 'reports.lat', 'reports.lng', 'reports.street_num', 'reports.street_name', 'reports.zip', 'reports.status', 'reports.type', 'reports.subtype')
        ->left_outer_join('users','users.email=reports.email')
        ->where('users.id', $args['uid'])->find_many();
    
    $user = ORM::for_table('users')
        ->where('users.id', $args['uid'])->find_one();
               
    
    return $this->view->render($response, 'profile.php', ['reports' => $reports, 'user' => $user]);
});
