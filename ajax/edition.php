<?php
include '../include/topscripts.php';

$error_message = '';
$id = filter_input(INPUT_GET, 'id');

$name = filter_input(INPUT_GET, 'name');
if($name !== null) {
    $error_message = (new Executer("update edition set name='$name' where id=$id"))->error;
    
    if($error_message == '') {
        $fetcher = new Fetcher("select name from edition where id=$id");
        $row = $fetcher->Fetch();
        $error_message = $fetcher->error;
        
        if($error_message == '') {
            echo $row['name'];
        }
    }
}

$organization = filter_input(INPUT_GET, 'organization');
if($organization !== null) {
    $error_message = (new Executer("update edition set organization='$organization' where id=$id"))->error;
    
    if($error_message == '') {
        $fetcher = new Fetcher("select organization from edition where id=$id");
        $row = $fetcher->Fetch();
        $error_message = $fetcher->error;
        
        if($error_message == '') {
            echo $row['organization'];
        }
    }
}

$length = filter_input(INPUT_GET, 'length');
if($length !== null) {
    $error_message = (new Executer("update edition set length='$length' where id=$id"))->error;
    
    if($error_message == '') {
        $fetcher = new Fetcher("select length from edition where id=$id");
        $row = $fetcher->Fetch();
        $error_message = $fetcher->error;
        
        if($error_message == '') {
            echo $row['length'];
        }
    }
}

$coloring = filter_input(INPUT_GET, 'coloring');
if($coloring !== null) {
    $error_message = (new Executer("update edition set coloring='$coloring' where id=$id"))->error;
    
    if($error_message == '') {
        $fetcher = new Fetcher("select coloring from edition where id=$id");
        $row = $fetcher->Fetch();
        $error_message = $fetcher->error;
        
        if($error_message == '') {
            echo $row['coloring'];
        }
    }
}

$comment = filter_input(INPUT_GET, 'comment');
if($comment !== null) {
    $comment = addslashes($comment);
    $error_message = (new Executer("update edition set comment='$comment' where id=$id"))->error;
    
    if($error_message == '') {
        $fetcher = new Fetcher("select comment from edition where id=$id");
        $row = $fetcher->Fetch();
        $error_message = $fetcher->error;
        
        if($error_message == '') {
            echo $row['comment'];
        }
    }
}

$roller_id = filter_input(INPUT_GET, 'roller_id');
if($roller_id !== null) {
    $error_message = (new Executer("update edition set roller_id=$roller_id where id=$id"))->error;
    
    if($error_message == '') {
        $fetcher = new Fetcher("select roller_id from edition where id=$id");
        $row = $fetcher->Fetch();
        $error_message = $fetcher->error;
        
        if($error_message == '') {
            echo $row['roller_id'];
        }
    }
}

if($error_message != '') {
    echo $error_message;
}
?>