<?php
$date_from = null;
$date_to = null;
$diff7Days = new DateInterval('P7D');
$diff14Days = new DateInterval('P14D');
$diff1Day = new DateInterval('P1D');

if(isset($_GET['from']) && $_GET['from'] != '') {
    $date_from = DateTime::createFromFormat("Y-m-d", $_GET['from']);
}

if(isset($_GET['to']) && $_GET['to'] != '') {
    $date_to = DateTime::createFromFormat("Y-m-d", $_GET['to']);
    //$date_to->add($diff1Day);
} 

if($date_from != null && $date_to == null) {
    $date_to = clone $date_from;
    $date_to->add($diff14Days);
    //$date_to->add($diff1Day);
} 

if($date_from == null && $date_to != null) {
    $date_from = clone $date_to;
    $date_from->sub($diff14Days);
    //$date_from->sub($diff1Day);
}

if($date_from != null && $date_to != null && $date_from >= $date_to) {
    $date_to = clone $date_from;
    //$date_to->add($diff14Days);
    //$date_to->add($diff1Day);
}
        
if($date_from == null && $date_to == null) {
    $date_from = new DateTime();
    $date_to = clone $date_from;
    $date_to->add($diff14Days);
    //$date_to->add($diff1Day);
}
?>

