<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        
        $machine_id = 6;
        
        // Выбор первого ламинаторщика
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laminator1_id'])) {
            $laminator1_id = $_POST['laminator1_id'];
            if($_POST['laminator1_id'] == '') $laminator1_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set laminator1_id=$laminator1_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, laminator1_id) values ('$date', '$shift', $laminator1_id)";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Создание нового первого ламинаторщика
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laminator1'])) {
            $laminator1 = addslashes($_POST['laminator1']);
            $sql_user = "insert into user (fio, username) values ('$laminator1', CURRENT_TIMESTAMP())";
            $conn_user = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
            if($conn_user->query($sql_user) === true) {
                $laminator1_id = $conn_user->insert_id;
                
                $role_id = 4;
                $sql_role = "insert into user_role (user_id, role_id) values ($laminator1_id, $role_id)";
                $error_message = ExecuteSql($sql_role);
                if($error_message == '') {
                    $sql = '';
                    
                    if(isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $sql = "update laminators set laminator1_id=$laminator1_id where id=$id";
                    }
                    else {
                        $date = $_POST['date'];
                        $shift = $_POST['shift'];
                        $sql = "insert into laminators (date, shift, laminator1_id) values ('$date', '$shift', $laminator1_id)";
                    }
                    $error_message = ExecuteSql($sql);
                }
            }
            else {
                $error_message = $conn_user->error;
            }
            
            $conn_user->close();
        }
        
        // Выбор второго ламинаторщика
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laminator2_id'])) {
            $laminator2_id = $_POST['laminator2_id'];
            if($_POST['laminator2_id'] == '') $laminator2_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set laminator2_id=$laminator2_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, laminator2_id) values ('$date', '$shift', $laminator2_id)";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Создание нового второго ламинаторщика
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laminator2'])) {
            $laminator2 = addslashes($_POST['laminator2']);
            $sql_user = "insert into user (fio, username) values ('$laminator2', CURRENT_TIMESTAMP())";
            $conn_user = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
            if($conn_user->query($sql_user) === true) {
                $laminator2_id = $conn_user->insert_id;
                
                $role_id = 4;
                $sql_role = "insert into user_role (user_id, role_id) values ($laminator2_id, $role_id)";
                $error_message = ExecuteSql($sql_role);
                if($error_message == '') {
                    $sql = '';
                    
                    if(isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $sql = "update laminators set laminator2_id=$laminator2_id where id=$id";
                    }
                    else {
                        $date = $_POST['date'];
                        $shift = $_POST['shift'];
                        $sql = "insert into laminators (date, shift, laminator2_id) values ('$date', '$shift', $laminator2_id)";
                    }
                    $error_message = ExecuteSql($sql);
                }
            }
            else {
                $error_message = $conn_user->error;
            }
            
            $conn_user->close();
        }
        
        // Заказчик
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['organization'])) {
            $organization = addslashes($_POST['organization']);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set organization='$organization' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, organization) values ('$date', '$shift', '$organization')";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Тираж
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edition'])) {
            $edition = addslashes($_POST['edition']);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set edition='$edition' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, edition) values ('$date', '$shift', '$edition')";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Метраж
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['length'])) {
            $length = filter_var($_POST['length'], FILTER_SANITIZE_NUMBER_INT);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set length='$length' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, length) values ('$date', '$shift', $length)";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Выбор вала
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roller_id'])) {
            $roller_id = $_POST['roller_id'];
            if($_POST['roller_id'] == '') $roller_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set roller_id=$roller_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, roller_id) values ('$date', '$shift', $roller_id)";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Выбор ламинации
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lamination_id'])) {
            $lamination_id = $_POST['lamination_id'];
            if($_POST['lamination_id'] == '') $lamination_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set lamination_id=$lamination_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, lamination_id) values ('$date', '$shift', $lamination_id)";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Менеджер
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['manager_id'])) {
            $manager_id = $_POST['manager_id'];
            if($_POST['manager_id'] == '') $manager_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set manager_id=$manager_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, manager_id, nn) values ('$date', '$shift', $manager_id, $nn)";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Комментарий
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
            $comment = addslashes($_POST['comment']);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update laminators set comment='$comment' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into laminators (date, shift, comment) values ('$date', '$shift', '$comment')";
            }
            
            $error_message = ExecuteSql($sql);
        }
        
        // Удаление рабочей смены
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_submit'])) {
            $id = $_POST['id'];
            $sql = "delete from laminators where id=$id";
            $error_message = ExecuteSql($sql);
        }
        
        // Получение начальной даты и конечной даты
        include '../include/date_from_date_to.php';
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
            ?>
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Ламинаторщики</h1>
                </div>
                <div class="p-1">
                    <?php
                    if(IsInRole('admin')) {
                    ?>
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="from">от&nbsp;</label>
                            <input type="date" id="from" name="from" class="form-control" value="<?=$_GET['from'] ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="to">&nbsp;до&nbsp;</label>
                            <input type="date" id="to" name="to" class="form-control" value="<?=$_GET['to'] ?>"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control">Показать</button>
                        </div>
                    </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <table class="table table-bordered typography">
                <thead id="grafik-thead">
                    <tr>
                        <th></th>
                        <th>Дата</th>
                        <th>Смена</th>
                        <th>Ламинаторщик 1</th>
                        <th>Ламинаторщик 2</th>
                        <th>Заказчик</th>
                        <th>Тираж</th>
                        <th>Метраж</th>
                        <th>Вал</th>
                        <th>Ламинация</th>
                        <th>Менеджер</th>
                        <th>Комментарий</th>
                        <?php
                        if(IsInRole('admin')) {
                            echo '<th></th>';
                        }
                        ?>
                    </tr>
                </thead>
                <tbody id="grafik-tbody">
                    <?php
                    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                    
                    if($conn->connect_error) {
                        die('Ошибка соединения: ' . $conn->connect_error);
                    }
                    
                    // Список ламинаторщиков
                    $laminators = array();
                    
                    if(IsInRole('admin')) {
                        $laminator_sql = "select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 4 order by u.fio";
                        $laminator_result = mysqli_query($conn, $laminator_sql);
                        if(is_bool($laminator_result)){
                            die("Ошибка при запросе списка ламинаторщиков");
                        }
                        else {
                            $laminators = mysqli_fetch_all($laminator_result, MYSQLI_ASSOC);
                        }
                    }
                    
                    // Список валов
                    $rollers = array();
                    
                    if(IsInRole('admin')) {
                        $roller_sql = "select id, name from roller where machine_id=$machine_id order by name";
                        $roller_result = mysqli_query($conn, $roller_sql);
                        if(is_bool($roller_result)) {
                            die("Ошибка при запросе списка валов");
                        }
                        else {
                            $rollers = mysqli_fetch_all($roller_result, MYSQLI_ASSOC);
                        }
                    }
                    
                    // Список ламинаций
                    $laminations = array();
                    
                    if(IsInRole('admin')) {
                        $lamination_sql = "select id, name from lamination where common = 1 order by sort";
                        $lamination_result = mysqli_query($conn, $lamination_sql);
                        if(is_bool($lamination_result)) {
                            die("Ошибка при запросе списка ламинаций");
                        }
                        else {
                            $laminations = mysqli_fetch_all($lamination_result, MYSQLI_ASSOC);
                        }
                    }
                    
                    // Список менеджеров
                    $managers = array();
                    
                    if(IsInRole('admin')) {
                        $manager_sql = "select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 2 order by u.fio";
                        $manager_result = mysqli_query($conn, $manager_sql);
                        if(is_bool($manager_result)){
                            die("Ошибка при запросе списка менеджеров");
                        }
                        else {
                            $managers = mysqli_fetch_all($manager_result, MYSQLI_ASSOC);
                        }
                    }
                    
                    // Список рабочих смен
                    $sql = "with recursive date_ranges as (select '".$date_from->format('Y-m-d')."' as date union all select date + interval 1 day from date_ranges where date < '".$date_to->format('Y-m-d')."') "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'day' shift, up.id p_id, up.fio p_name, ua.id a_id, ua.fio a_name, um.id m_id, um.fio m_name, "
                            . "t.organization, t.edition, t.length, r.name roller, lam.name lamination, t.roller_id, t.lamination_id, t.comment "
                            . "from date_ranges dr left join laminators t "
                            . "left join user up on t.laminator1_id = up.id "
                            . "left join user ua on t.laminator2_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join roller r on t.roller_id = r.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "on t.date = dr.date and t.shift = 'day' "
                            . "union "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'night' shift, up.id p_id, up.fio p_name, ua.id a_id, ua.fio a_name, um.id m_id, um.fio m_name, "
                            . "t.organization, t.edition, t.length, r.name roller, lam.name lamination, t.roller_id, t.lamination_id, t.comment "
                            . "from date_ranges dr left join laminators t "
                            . "left join user up on t.laminator1_id = up.id "
                            . "left join user ua on t.laminator2_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join roller r on t.roller_id = r.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "on t.date = dr.date and t.shift = 'night' "
                            . "order by date desc, shift asc;";
                    
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $top = "";
                            if($row['shift'] == 'day') {
                                $top = " class='top'";
                            }
                            
                            echo '<tr>';
                            if($row['shift'] == 'day') {
                                echo "<td".$top." rowspan='2'>".$weekdays[DateTime::createFromFormat('d.m.Y', $row['fdate'])->format('w')].'</td>';
                                echo "<td".$top." rowspan='2'>".$row['fdate'].'</td>';
                            }
                            echo '<td'.$top.'>'.($row['shift'] == 'day' ? 'День' : 'Ночь').'</td>';
                            
                            // Ламинаторщик 1
                            echo '<td'.$top.' title="Ламинаторщик 1">';
                            if(IsInRole('admin')) {
                                echo "<form method='post'>";
                                AddHiddenFields($row);
                                echo '<select id="laminator1_id" name="laminator1_id">';
                                echo '<optgroup>';
                                echo '<option value="">...</option>';
                                foreach ($laminators as $value) {
                                    $selected = '';
                                    if($row['p_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['fio']."</option>";
                                }
                                echo '</optgroup>';
                                echo "<optgroup label='______________'>";
                                echo "<option value='+'>(добавить)</option>";
                                echo '</optgroup>';
                                echo '</select>';
                                echo '</form>';
                                
                                echo '<form method="post" class="d-none">';
                                AddHiddenFields($row);
                                echo '<div class="input-group">';
                                echo '<input type="text" id="laminator1" name="laminator1" value="" class="editable" />';
                                echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['p_name'];
                            }
                            echo '</td>';
                            
                            // Ламинаторщик 2
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
                                AddHiddenFields($row);
                                echo '<select id="laminator2_id" name="laminator2_id">';
                                echo '<optgroup>';
                                echo '<option value="">...</option>';
                                foreach ($laminators as $value) {
                                    $selected = '';
                                    if($row['a_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['fio']."</option>";
                                }
                                echo '</optgroup>';
                                echo "<optgroup label='______________'>";
                                echo "<option value='+'>(добавить)</option>";
                                echo '</optgroup>';
                                echo '</select>';
                                echo '</form>';
                                
                                echo '<form method="post" class="d-none">';
                                AddHiddenFields($row);
                                echo '<div class="input-group">';
                                echo '<input type="text" id="laminator2" name="laminator2" value="" class="editable" />';
                                echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['a_name'];
                            }
                            echo '</td>';
                            
                            // Заказчик
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
                                AddHiddenFields($row);
                                echo '<div class="input-group">';
                                echo '<input type="text" id="organization" name="organization" value="'.htmlentities($row['organization']).'" class="editable" />';
                                echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['organization'];
                            }
                            echo '</td>';
                            
                            // Тираж
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
                                AddHiddenFields($row);
                                echo '<div class="input-group">';
                                echo '<input type="text" id="edition" name="edition" value="'.htmlentities($row['edition']).'" class="editable" />';
                                echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['edition'];
                            }
                            echo '</td>';
                            
                            // Метраж
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
                                AddHiddenFields($row);
                                echo '<div class="input-group">';
                                echo '<input type="number" step="1" id="length" name="length" value="'.$row['length'].'" class="editable" />';
                                echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['length'];
                            }
                            echo '</td>';
                            
                            // Вал
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo "<form method='post'>";
                                AddHiddenFields($row);
                                echo '<select onchange="javascript: this.form.submit();" id="roller_id" name="roller_id">';
                                echo '<option value="">...</option>';
                                foreach ($rollers as $value) {
                                    $selected = '';
                                    if($row['roller_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['name']."</option>";
                                }
                                echo '</select>';
                                echo '</form>';
                            }
                            else {
                                echo $row['roller'];
                            }
                            echo '</td>';
                            
                            // Ламинация
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo "<form method='post'>";
                                AddHiddenFields($row);
                                echo '<select onchange="javascript: this.form.submit();" id="lamination_id" name="lamination_id">';
                                echo '<option value="">...</option>';
                                foreach ($laminations as $value) {
                                    $selected = '';
                                    if($row['lamination_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['name']."</option>";
                                }
                                echo '</select>';
                                echo '</form>';
                            }
                            else {
                                echo $row['lamination'];
                            }
                            echo '</td>';
                            
                            // Менеджер
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo "<form method='post'>";
                                AddHiddenFields($row);
                                echo '<select id="manager_id" name="manager_id">';
                                echo '<option value="">...</option>';
                                foreach ($managers as $value) {
                                    $selected = '';
                                    if($row['m_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['fio']."</option>";
                                }
                                echo '</select>';
                                echo '</form>';
                            }
                            else {
                                echo $row['m_name'];
                            }
                            echo '</td>';
                            
                            // Комментарий
                            echo "<td".$top." class='newline'>";
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
                                AddHiddenFields($row);
                                echo '<div class="input-group">';
                                echo '<input type="text" id="comment" name="comment" value="'. htmlentities($row['comment']).'" class="editable" />';
                                echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['comment'];
                            }
                            echo "</td>";
                            
                            // Удаление смены
                            if(IsInRole('admin')) {
                                echo '<td'.$top.'>';
                                if(isset($row['id'])) {
                                    echo "<form method='post'>";
                                    echo '<input type="hidden" id="scroll" name="scroll" />';
                                    echo "<input type='hidden' id='id' name='id' value='".$row['id']."' />";
                                    echo "<input type='hidden' id='date' name='date' value='".$row['date']."' />";
                                    if(isset($_GET['from'])) {
                                        echo '<input type="hidden" id="from" name="from" value="'.$_GET['from'].'" />';
                                    }
                                    if(isset($_GET['to'])) {
                                        echo '<input type="hidden" id="to" name="to" value="'.$_GET['to'].'" />';
                                    }
                                    echo "<button type='submit' id='delete_submit' name='delete_submit' class='btn btn-outline-dark' onclick='javascript:return confirm(\"Действительно удалить?\");'><span class='font-awesome'>&#xf1f8;</span></button>";
                                    echo '</form>';
                                }
                                echo '</td>';
                            }

                            echo '</tr>';
                        }
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        include '../include/footer.php';
        ?>
        <script>
            $('select[id=laminator1_id],select[id=laminator2_id],select[id=manager_id]').change(function(){
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