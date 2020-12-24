<?php
include '../include/topscripts.php';

$error_message = '';

$edition = filter_input(INPUT_GET, 'edition');
if($edition !== null) {
    $name = null;
    $organization = null;
    $length = null;
    $status_id = null;
    $lamination_id = null;
    $coloring = null;
    $roller_id = null;
    $manager_id = null;
    $comment = null;
    $user1_id = null;
    $user2_id = null;
    
    $sql = "select e.name, e.organization, e.length, e.status_id, e.lamination_id, e.coloring, e.roller_id, e.manager_id, e.comment, ws.user1_id, ws.user2_id "
            . "from edition e "
            . "inner join workshift ws on e.workshift_id=ws.id "
            . "where e.id=$edition";
    
    $fetcher = new Fetcher($sql);
    $row = $fetcher->Fetch();
    $error_message = $fetcher->Fetch();
    if($fetcher->error == '') {
        $name = $row['name'];
        $organization = $row['organization'];
        $length = $row['length'];
        $status_id = $row['status_id'];
        $lamination_id = $row['lamination_id'];
        $coloring = $row['coloring'];
        $roller_id = $row['roller_id'];
        $manager_id = $row['manager_id'];
        $comment = $row['comment'];
        $user1_id = $row['user1_id'];
        $user2_id = $row['user2_id'];
    
        echo $user1_id.' '.$organization.' '.$name;
    }
}

if($error_message != '') {
    echo $error_message;
}
?>