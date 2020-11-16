<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';

        // Выбор печатника
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['typographer_id'])) {
            $typographer_id = $_POST['typographer_id'];
            if($_POST['typographer_id'] == '') $typographer_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update comiflex set typographer_id=$typographer_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into comiflex (date, shift, typographer_id) values ('$date', '$shift', $typographer_id)";
            }
            
            $error_message = ExecuteSql($sql, 'comiflex');
        }
        
        // Выбор помощника
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assistant_id'])) {
            $assistant_id = $_POST['assistant_id'];
            if($_POST['assistant_id'] == '') $assistant_id = "NULL";
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update comiflex set assistant_id=$assistant_id where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into comiflex (date, shift, assistant_id) values ('$date', '$shift', $assistant_id)";
            }
            
            $error_message = ExecuteSql($sql, 'comiflex');
        }
        
        // Заказчика
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['organization'])) {
            $organization = addslashes($_POST['organization']);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update comiflex set organization='$organization' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into comiflex (date, shift, organization) values ('$date', '$shift', '$organization')";
            }
            
            $error_message = ExecuteSql($sql, 'comiflex');
        }
        
        // Тираж
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edition'])) {
            $edition = addslashes($_POST['edition']);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update comiflex set edition='$edition' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into comiflex (date, shift, edition) values ('$date', '$shift', '$edition')";
            }
            
            $error_message = ExecuteSql($sql, 'comiflex');
        }
        
        // Метраж
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['length'])) {
            $length = filter_var($_POST['length'], FILTER_SANITIZE_NUMBER_INT);
            $sql = '';
            
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                $sql = "update comiflex set length='$length' where id=$id";
            }
            else {
                $date = $_POST['date'];
                $shift = $_POST['shift'];
                $sql = "insert into comiflex (date, shift, length) values ('$date', '$shift', $length)";
            }
            
            $error_message = ExecuteSql($sql, 'comiflex');
        }
        
        // Удаление рабочей смены
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_submit'])) {
            $id = $_POST['id'];
            $sql = "delete from comiflex where id=$id";
            $error_message = ExecuteSql($sql, 'comiflex');
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
                    <h1>Comiflex</h1>
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
                        <th>Печатник</th>
                        <th>Помощник</th>
                        <th>Заказчик</th>
                        <th>Тираж</th>
                        <th>Метраж</th>
                        <th>Вал</th>
                        <th>Ламинация</th>
                        <th>Красочность</th>
                        <th>Менеджер</th>
                        <?php
                        if(IsInRole('admin')) {
                            echo '<th></th>';
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
                    
                    // Список печатников
                    $typographers = array();
                    
                    if(IsInRole('admin')) {
                        $typographer_sql = "select u.id, u.last_name, u.first_name, u.middle_name from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 3";
                        $typographer_result = mysqli_query($conn, $typographer_sql);
                        if(is_bool($typographer_result)){
                            die("Ошибка при запросе списка печатников");
                        }
                        else {
                            $typographers = mysqli_fetch_all($typographer_result, MYSQLI_ASSOC);
                        }
                    }
                    
                    // Список рабочих смен
                    $sql = "with recursive date_ranges as (select '".$date_from->format('Y-m-d')."' as date union all select date + interval 1 day from date_ranges where date < '".$date_to->format('Y-m-d')."') "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'day' shift, "
                            . "up.id p_id, up.last_name p_last_name, up.first_name p_first_name, up.middle_name p_middle_name, "
                            . "ua.id a_id, ua.last_name a_last_name, ua.first_name a_first_name, ua.middle_name a_middle_name, "
                            . "t.organization, t.edition, t.length, lam.name lamination, t.coloring, t.roller, "
                            . "um.last_name m_last_name, um.first_name m_first_name, um.middle_name m_middle_name "
                            . "from date_ranges dr left join comiflex t "
                            . "left join user up on t.typographer_id = up.id "
                            . "left join user ua on t.assistant_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "on t.date = dr.date and t.shift = 'day' "
                            . "union "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'night' shift, "
                            . "up.id p_id, up.last_name p_last_name, up.first_name p_first_name, up.middle_name p_middle_name, "
                            . "ua.id a_id, ua.last_name a_last_name, ua.first_name a_first_name, ua.middle_name a_middle_name, "
                            . "t.organization, t.edition, t.length, lam.name lamination, t.coloring, t.roller, "
                            . "um.last_name m_last_name, um.first_name m_first_name, um.middle_name m_middle_name "
                            . "from date_ranges dr left join comiflex t "
                            . "left join user up on t.typographer_id = up.id "
                            . "left join user ua on t.assistant_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
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
                            
                            // Печатник
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo "<form method='post'>";
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
                                echo '<select onchange="javascript: this.form.submit();" id="typographer_id" name="typographer_id">';
                                echo '<option value="">...</option>';
                                foreach ($typographers as $value) {
                                    $selected = '';
                                    if($row['p_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['last_name'].' '.(mb_strlen($value['first_name']) > 1 ? mb_substr($value['first_name'], 0, 1).'.' : $value['first_name']).' '.(mb_strlen($value['middle_name']) > 1 ? mb_substr($value['middle_name'], 0, 1).'.' : $value['middle_name'])."</option>";
                                }
                                echo '</select>';
                                echo '</form>';
                            }
                            else {
                                echo $row['p_last_name'].' '.(mb_strlen($row['p_first_name']) > 1 ? mb_substr($row['p_first_name'], 0, 1).'.' : $row['p_first_name']).' '.(mb_strlen($row['p_middle_name']) > 1 ? mb_substr($row['p_middle_name'], 0, 1).'.' : $row['p_middle_name']);
                            }
                            echo '</td>';
                            
                            // Помощник
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
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
                                echo '<select onchange="javascript:this.form.submit();" id="assistant_id" name="assistant_id">';
                                echo '<option value="">...</option>';
                                foreach ($typographers as $value) {
                                    $selected = '';
                                    if($row['a_id'] == $value['id']) $selected = " selected = 'selected'";
                                    echo "<option$selected value='".$value['id']."'>".$value['last_name'].' '.(mb_strlen($value['first_name']) > 1 ? mb_substr($value['first_name'], 0, 1).'.' : $value['first_name']).' '.(mb_strlen($value['middle_name']) > 1 ? mb_substr($value['middle_name'], 0, 1).'.' : $value['middle_name'])."</option>";
                                }
                                echo '</select>';
                                echo '</form>';
                            }
                            else {
                                echo $row['a_last_name'].' '.(mb_strlen($row['a_first_name']) > 1 ? mb_substr($row['a_first_name'], 0, 1).'.' : $row['a_first_name']).' '.(mb_strlen($row['a_middle_name']) > 1 ? mb_substr($row['a_middle_name'], 0, 1).'.' : $row['a_middle_name']);
                            }
                            echo '</td>';

                            // Заказчик
                            echo '<td'.$top.'>';
                            if(IsInRole('admin')) {
                                echo '<form method="post">';
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
                                echo '<div class="input-group">';
                                echo '<input type="text" id="organization" name="organization" value="'.htmlentities($row['organization']).'" class="editable" />';
                                echo '<div class="input-group-append invisible"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
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
                                echo '<div class="input-group">';
                                echo '<input type="text" id="edition" name="edition" value="'.htmlentities($row['edition']).'" class="editable" />';
                                echo '<div class="input-group-append invisible"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
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
                                echo '<div class="input-group">';
                                echo '<input type="number" step="1" id="length" name="length" value="'.$row['length'].'" class="editable" />';
                                echo '<div class="input-group-append invisible"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                                echo '</div>';
                                echo '</form>';
                            }
                            else {
                                echo $row['edition'];
                            }
                            echo '</td>';
                            
                            // Вал
                            echo '<td'.$top.'>'.$row['roller'].'</td>';
                            echo '<td'.$top.'>'.$row['lamination'].'</td>';
                            echo '<td'.$top.'>'.$row['coloring'].'</td>';
                            echo '<td'.$top.'>'.$row['m_last_name'].' '.(mb_strlen($row['m_first_name']) > 1 ? mb_substr($row['m_first_name'], 0, 1).'.' : $row['m_first_name']).' '.(mb_strlen($row['m_middle_name']) > 1 ? mb_substr($row['m_middle_name'], 0, 1).'.' : $row['m_middle_name']).'</td>';
                            
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
    </body>
</html>