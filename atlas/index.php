<?php
include '../include/topscripts.php';
include '../include/grafik.php';
include '../include/date_from_date_to.php';

$nn = 99;
$machine_id = 5;

$grafik = new Grafik($date_from, $date_to);

$grafik->hasTypographer = true;
$grafik->sqlTypographers = "select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 3 order by u.fio";
$grafik->tableNameTypographer = "zbs";

$grafik->hasOrganization = true;
$grafik->hasEdition = true;
$grafik->hasLength = true;
$grafik->hasRoller = true;
$grafik->hasLamination = true;
$grafik->hasColoring = true;
$grafik->hasManager = true;


$grafik->sqlRollers = "select id, name from roller where machine_id=$machine_id order by name";
$grafik->sqlLaminations = "select id, name from lamination where common = 1 order by sort";
$grafik->sqlManagers = "select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 2 order by u.fio";
$grafik->sqlShifts = "select t.id, t.date date, date_format(t.date, '%d.%m.%Y') fdate, t.shift, up.id p_id, up.fio p_name, um.id m_id, um.fio m_name, "
        . "t.organization, t.edition, t.length, r.name roller, lam.name lamination, t.coloring, t.roller_id, t.lamination_id "
        . "from zbs t "
        . "left join user up on t.typographer_id = up.id "
        . "left join user um on t.manager_id = um.id "
        . "left join roller r on t.roller_id = r.id "
        . "left join lamination lam on t.lamination_id = lam.id "
        . "where t.date >= '".$date_from->format('Y-m-d')."' and t.date <= '".$date_to->format('Y-m-d')."' and t.nn = $nn";

// Выбор печатника
$typographer_id = filter_input(INPUT_POST, 'typographer_id');
if($typographer_id !== null) {
    if($typographer_id == '') $typographer_id = "NULL";
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set typographer_id=$typographer_id where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, typographer_id, nn) values ('$date', '$shift', $typographer_id, $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}

// Создание нового печатника
$typographer = filter_input(INPUT_POST, 'typographer');
if($typographer !== null) {
    $typographer = addslashes($typographer);
    $u_executer = new Executer("insert into user (fio, username) values ('$typographer', CURRENT_TIMESTAMP())");
    $error_message = $u_executer->error;
    $typographer_id = $u_executer->insert_id;
    
    if ($typographer_id > 0) {
        $role_id = 3;
        $r_executer = new Executer("insert into user_role (user_id, role_id) values ($typographer_id, $role_id)");
        $error_message = $r_executer->error;
        
        if($error_message == ''){
            $sql = '';
            $id = filter_input(INPUT_POST, 'id');
            
            if($id !== null) {
                $sql = "update zbs set typographer_id=$typographer_id where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into zbs (date, shift, typographer_id, nn) values ('$date', '$shift', $typographer_id, $nn)";
            }
            $error_message = (new Executer($sql))->error;
        }
    }
}

// Заказчик
$organization = filter_input(INPUT_POST, 'organization');
if($organization !== null) {
    $organization = addslashes($organization);
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set organization='$organization' where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, organization, nn) values ('$date', '$shift', '$organization', $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}

// Тираж
$edition = filter_input(INPUT_POST, 'edition');
if($edition !== null) {
    $edition = addslashes($edition);
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set edition='$edition' where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, edition, nn) values ('$date', '$shift', '$edition', $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}
        
// Метраж
$length = filter_input(INPUT_POST, 'length');
if($length !== null) {
    $length = filter_var($length, FILTER_SANITIZE_NUMBER_INT);
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set length='$length' where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, length, nn) values ('$date', '$shift', $length, $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}

// Выбор вала
$roller_id = filter_input(INPUT_POST, 'roller_id');
if($roller_id !== null) {
    if($roller_id == '') $roller_id = "NULL";
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set roller_id=$roller_id where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, roller_id, nn) values ('$date', '$shift', $roller_id, $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}
        
// Выбор ламинации
$lamination_id = filter_input(INPUT_POST, 'lamination_id');
if($lamination_id !== null) {
    if($lamination_id == '') $lamination_id = "NULL";
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set lamination_id=$lamination_id where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, lamination_id, nn) values ('$date', '$shift', $lamination_id, $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}

// Красочность
$coloring = filter_input(INPUT_POST, 'coloring');
if($coloring !== null) {
    $coloring = filter_var($coloring, FILTER_SANITIZE_NUMBER_INT);
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set coloring='$coloring' where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, coloring, nn) values ('$date', '$shift', $coloring, $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}

// Менеджер
$manager_id = filter_input(INPUT_POST, 'manager_id');
if($manager_id !== null) {
    if($manager_id == '') $manager_id = "NULL";
    $sql = '';
    $id = filter_input(INPUT_POST, 'id');
    
    if($id !== null) {
        $sql = "update zbs set manager_id=$manager_id where id=$id";
    }
    else {
        $date = filter_input(INPUT_POST, 'date');
        $shift = filter_input(INPUT_POST, 'shift');
        $sql = "insert into zbs (date, shift, manager_id, nn) values ('$date', '$shift', $manager_id, $nn)";
    }
    
    $error_message = (new Executer($sql))->error;
}

// Удаление рабочей смены
if(filter_input(INPUT_POST, 'delete_submit') !== null) {
    $id = filter_input(INPUT_POST, 'id');
    $sql = "delete from zbs where id=$id";
    $error_message = (new Executer($sql))->error;
}

// Получение начальной даты и конечной даты
include '../include/date_from_date_to.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>График - Атлас</title>
        <?php
        include '../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container-fluid">
            <?php
            if(isset($error_message) && $error_message != '') {
               echo "<div class='alert alert-danger'>$error_message</div>";
            }
            $grafik->ShowPage();
            ?>
        </div>
        <?php
        include '../include/footer.php';
        ?>
        <script>
            $('select[id=typographer_id],select[id=assistant_id],select[id=laminator1_id],select[id=laminator2_id],select[id=cutter_id],select[id=manager_id]').change(function(){
                if(this.value == '+') {
                    $(this).parent().next().removeClass('d-none');
                    $(this).parent().addClass('d-none');
                    return;
                }
                this.form.submit();
            });
        </script>
    </body>
</html>