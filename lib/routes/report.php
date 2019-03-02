<?php

$app->get('/report/{id}', function ($request, $response, $args) {
    $report = ORM::for_table('reports')
        ->where('id', $args['id'])
        ->find_one();
    
    $images = ORM::for_table('images')
        ->where('ticket_id', $args['id'])
        ->find_many();
    
    return $this->view->render($response, 'report.php', ['report' => $report, 'images' => $images]);
});