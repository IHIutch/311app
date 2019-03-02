<?php


$app->get('/reports', function ($request, $response) {
    $count = ORM::for_table('reports')->count();
    $report_list = ORM::for_table('reports')->find_many();
    
    return $this->view->render($response, 'report_list.php', ['report_list' => $report_list, 'count' => $count]);
});

?>