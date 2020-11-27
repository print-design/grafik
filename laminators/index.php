<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        
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
        if($_SERVER['REQUET_METOD'] == 'POST' && isset($_POST['laminator1'])) {
            $laminator1 = addslashes($_POST['laminator1']);
            $sql_user = "insert into user (fio, username) values ('$laminator1', CURRENT_TIMESTAMP())";
            $conn_user = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
            if($conn_user->query($sql_user) === true) {
                $laminator1_id = $conn_user->insert_id;
                
                $role_id = 4;
                $sql_role = "insert into user_role (user_id, role_d) values ($laminator1_id, $role_id)";
                $error_message = ExecuteSql($sql_role);
                if($error_message = '') {
                    $sql = '';
                    
                    if(isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $sql = "update laminators set laminator1_id=$laminator1_id where id=$id";
                    }
                    else {
                        $date = $_POST['date'];
                        $shift = $_POST['shift'];
                        $sql = "insert into laminators (date, shift. laminator1_id) values ('$date', '$shift', $laminator1_id)";
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
        if($_SERVER['REQUET_METOD'] == 'POST' && isset($_POST['laminator2'])) {
            $laminator2 = addslashes($_POST['laminator2']);
            $sql_user = "insert into user (fio, username) values ('$laminator2', CURRENT_TIMESTAMP())";
            $conn_user = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
            if($conn_user->query($sql_user) === true) {
                $laminator2_id = $conn_user->insert_id;
                
                $role_id = 4;
                $sql_role = "insert into user_role (user_id, role_d) values ($laminator2_id, $role_id)";
                $error_message = ExecuteSql($sql_role);
                if($error_message = '') {
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
                $sql = "update zbs set organization='$organization' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into zbs (date, shift, organization, nn) values ('$date', '$shift', '$organization', $nn)";
            }
            
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
               echo <<<ERROR
               <div class="alert alert-danger">$error_message</div>
               ERROR;
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
                <thead>
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
                        ?>
                        <th></th>
                        <th></th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                    
                    if($conn->connect_error) {
                        die('Ошибка соединения: ' . $conn->connect_error);
                    }
                    
                    $sql = "with recursive date_ranges as (select '".$date_from->format('Y-m-d')."' as date union all select date + interval 1 day from date_ranges where date < '".$date_to->format('Y-m-d')."') "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'day' shift, "
                            . "up.name p_name, "
                            . "ua.name a_name, "
                            . "org.name organization, ed.name edition, t.length, lam.name lamination, t.roller, t.comment, "
                            . "um.name m_name "
                            . "from date_ranges dr left join laminators t "
                            . "left join user up on t.laminator1_id = up.id "
                            . "left join user ua on t.laminator2_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join organization org on t.organization_id = org.id "
                            . "left join edition ed on t.edition_id = ed.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "on t.date = dr.date and t.shift = 'day' "
                            . "union "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'night' shift, "
                            . "up.name p_name, "
                            . "ua.name a_name, "
                            . "org.name organization, ed.name edition, t.length, lam.name lamination, t.roller, t.comment, "
                            . "um.name m_name "
                            . "from date_ranges dr left join laminators t "
                            . "left join user up on t.laminator1_id = up.id "
                            . "left join user ua on t.laminator2_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join organization org on t.organization_id = org.id "
                            . "left join edition ed on t.edition_id = ed.id "
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
                            echo '<td'.$top.'>'.$row['p_name'].'</td>';
                            echo '<td'.$top.'>'.$row['a_name'].'</td>';
                            echo '<td'.$top.'>'.$row['organization'].'</td>';
                            echo '<td'.$top.'>'.$row['edition'].'</td>';
                            echo '<td'.$top.'>'.$row['length'].'</td>';
                            echo '<td'.$top.'>'.$row['roller'].'</td>';
                            echo '<td'.$top.'>'.$row['lamination'].'</td>';
                            echo '<td'.$top.'>'.$row['m_name'].'</td>';
                            echo "<td".$top." class='newline'>".$row['comment']."</td>";
                            
                            if(IsInRole('admin')) {
                                echo '<td'.$top.'>';
                                if(isset($row['id'])) {
                                    echo "<a title='Редактировать смену' href='edit.php?id=".$row['id']."&from=".(isset($_GET['from']) ? $_GET['from'] : '')."&to=".(isset($_GET['to']) ? $_GET['to'] : '')."' class='btn btn-outline-dark'><span class='font-awesome'>&#xf044;</span>";
                                }
                                else {
                                    echo "<a title='Создать смену' href='create.php?date=".$row['date']."&shift=".$row['shift']."&from=".(isset($_GET['from']) ? $_GET['from'] : '')."&to=".(isset($_GET['to']) ? $_GET['to'] : '')."' class='btn btn-outline-dark'><span class='font-awesome'>&#xf067;</span>";
                                }
                                echo '</td>';
                                
                                echo '<td'.$top.'>';
                                if(isset($row['id'])) {
                                    echo "<a title='Удалить смену' href='delete.php?id=".$row['id']."&from=".(isset($_GET['from']) ? $_GET['from'] : '')."&to=".(isset($_GET['to']) ? $_GET['to'] : '')."' class='btn btn-outline-dark'><span class='font-awesome'>&#xf1f8;</span>";
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
    </body>
</html>