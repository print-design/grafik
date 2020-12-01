<?php
include 'defines.php';

$weekdays = array();
$weekdays[0] = 'Вс';
$weekdays[1] = 'Пн';
$weekdays[2] = 'Вт';
$weekdays[3] = 'Ср';
$weekdays[4] = 'Чт';
$weekdays[5] = 'Пт';
$weekdays[6] = 'Сб';

// Функции
function LoggedIn() {
    if(isset($_COOKIE[USERNAME]) && $_COOKIE[USERNAME] != '') {
        return true;
    }
    else {
        return false;   
    }
}

function GetUserId() {
    return $_COOKIE[USER_ID];
}

function IsInRole($role) {
    if(isset($_COOKIE[ROLES])) {
        $roles = unserialize($_COOKIE[ROLES]);
        if(in_array($role, $roles))
                return true;
    }
    
    return false;
}

function ExecuteSql($sql) {
    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
    $message = '';
    
    if($conn->connect_error) {
        $message = $conn->connect_error;
    }
    
    if($conn->query($sql) != true) {
        $message = $conn->error;
    }
    
    $conn->close();
    return $message;
}

function AddHiddenFields($row) {
    echo '<input type="hidden" id="scroll" name="scroll" />';
    if(isset($row['id'])) {
        echo '<input type="hidden" id="id" name="id" value="'.$row['id'].'" />';
    }
    echo '<input type="hidden" id="date" name="date" value="'.$row['date'].'" />';
    echo '<input type="hidden" id="shift" name="shift" value="'.$row['shift'].'" />';
    if(isset($_GET['from'])) {
        echo '<input type="hidden" id="from" name="from" value="'.$_GET['from'].'" />';
    }
    if(isset($_GET['to'])) {
        echo '<input type="hidden" id="to" name="to" value="'.$_GET['to'].'" />';
    }
}
?>
<meta charset="UTF-8">
<title>Принт-дизайн. График работы сотрудиков</title>
<link href="<?=APPLICATION ?>/css/bootstrap.css" rel="stylesheet" rel="stylesheet" />
<link href="<?=APPLICATION ?>/css/main.css" rel="stylesheet" rel="stylesheet" />
<link rel="icon" type="image/png" href="<?=APPLICATION ?>/favicon.ico" />