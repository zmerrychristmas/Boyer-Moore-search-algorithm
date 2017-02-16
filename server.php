<?php
    set_time_limit(100);
    include('search.php');
    $result = [
        'status'    => 0,
        'index'     =>  []
    ];
    if (isset($_POST['search'])) {
        $subString = isset($_POST['sub-string']) ? $_POST['sub-string'] : '';
        $mainString = isset($_POST['main-string']) ? $_POST['main-string'] : '';
        $index = Search::search($subString, $mainString);
        $result['status'] = 1;
        $result['index'] = $index;
    } else {
        $result['status'] = 0;
    }
    header('Content-Type: application/json');
    echo json_encode($result);
