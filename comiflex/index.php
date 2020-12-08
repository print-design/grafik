<?php
include '../include/topscripts.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        
        $machine_id = 1;

        // Выбор печатника
        $typographer_id = filter_input(INPUT_POST, 'typographer_id');
        if($typographer_id !== null) {
            if($typographer_id == '') $typographer_id = "NULL";
            $sql = '';
            $id = filter_input(INPUT_POST, 'id');
            
            if($id !== null) {
                $sql = "update comiflex set typographer_id=$typographer_id where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, typographer_id) values ('$date', '$shift', $typographer_id)";
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
            
            if($typographer_id > 0) {
                $role_id = 3;
                $r_executer = new Executer("insert into user_role (user_id, role_id) values ($typographer_id, $role_id)");
                $error_message = $r_executer->error;
                
                if($r_executer->error == '') {
                    $sql = '';
                    $id = filter_input(INPUT_POST, 'id');
                    
                    if($id !== null) {
                        $sql = "update comiflex set typographer_id=$typographer_id where id=$id";
                    }
                    else {
                        $date = filter_input(INPUT_POST, 'date');
                        $shift = filter_input(INPUT_POST, 'shift');
                        $sql = "insert into comiflex (date, shift, typographer_id) values ('$date', '$shift', $typographer_id)";
                    }
                    $error_message = (new Executer($sql))->error;
                }
            }
        }
        
        // Выбор помощника
        $assistant_id = filter_input(INPUT_POST, 'assistant_id');
        if($assistant_id !== null) {
            if($assistant_id == '') $assistant_id = "NULL";
            $sql = '';
            $id = filter_input(INPUT_POST, 'id');
            
            if($id !== null) {
                $sql = "update comiflex set assistant_id=$assistant_id where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, assistant_id) values ('$date', '$shift', $assistant_id)";
            }
            $error_message = (new Executer($sql))->error;
        }
        
        // Создание нового помощника
        $assistant = filter_input(INPUT_POST, 'assistant');
        if($assistant !== null) {
            $assistant = addslashes($assistant);
            $u_executer = new Executer("insert into user (fio, username) values ('$assistant', CURRENT_TIMESTAMP())");
            $error_message = $u_executer->error;
            $assistant_id = $u_executer->insert_id;
            
            if($assistant_id > 0) {
                $role_id = 3;
                $r_executer = new Executer("insert into user_role (user_id, role_id) values ($assistant_id, $role_id)");
                $error_message = $r_executer->error;
                
                if($r_executer->error == '') {
                    $sql = '';
                    $id = filter_input(INPUT_POST, 'id');
                    
                    if($id !== null) {
                        $sql = "update comiflex set assistant_id=$assistant_id where id=$id";
                    }
                    else {
                        $date = filter_input(INPUT_POST, 'date');
                        $shift = filter_input(INPUT_POST, 'shift');
                        $sql = "insert into comiflex (date, shift, assistant_id) values ('$date', '$shift', $assistant_id)";
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
                $sql = "update comiflex set organization='$organization' where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, organization) values ('$date', '$shift', '$organization')";
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
                $sql = "update comiflex set edition='$edition' where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, edition) values ('$date', '$shift', '$edition')";
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
                $sql = "update comiflex set length='$length' where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, length) values ('$date', '$shift', $length)";
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
                $sql = "update comiflex set roller_id=$roller_id where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, roller_id) values ('$date', '$shift', $roller_id)";
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
                $sql = "update comiflex set lamination_id=$lamination_id where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, lamination_id) values ('$date', '$shift', $lamination_id)";
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
                $sql = "update comiflex set coloring='$coloring' where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, coloring) values ('$date', '$shift', $coloring)";
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
                $sql = "update comiflex set manager_id=$manager_id where id=$id";
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into comiflex (date, shift, manager_id) values ('$date', '$shift', $manager_id)";
            }
            
            $error_message = (new Executer($sql))->error;
        }
        
        // Удаление рабочей смены
        if(filter_input(INPUT_POST, 'delete_submit') !== null) {
            $id = filter_input(INPUT_POST, 'id');
            $sql = "delete from comiflex where id=$id";
            $error_message = (new Executer($sql))->error;
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
                    <h1>Comiflex</h1>
                </div>
                <div class="p-1">
                    <?php
                    if(IsInRole('admin')) {
                    ?>
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="from">от&nbsp;</label>
                            <input type="date" id="from" name="from" class="form-control" value="<?= filter_input(INPUT_GET, 'from') ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="to">&nbsp;до&nbsp;</label>
                            <input type="date" id="to" name="to" class="form-control" value="<?= filter_input(INPUT_GET, 'to') ?>"/>
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
                <tbody id="grafik-tbody">
                    <?php
                    // Список печатников
                    if(IsInRole('admin')) {
                        $typographers = (new Grabber("select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 3 order by u.fio"))->result;
                    }
                    
                    // Список валов
                    if(IsInRole('admin')) {
                        $rollers = (new Grabber("select id, name from roller where machine_id=$machine_id order by name"))->result;
                    }
                    
                    // Список ламинаций
                    if(IsInRole('admin')) {
                        $laminations = (new Grabber("select id, name from lamination where common = 1 order by sort"))->result;
                    }
                    
                    // Список менеджеров
                    if(IsInRole('admin')) {
                        $managers = (new Grabber("select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 2 order by u.fio"))->result;
                    }
                    
                    // Список рабочих смен
                    $sql = "select t.id, t.date date, date_format(t.date, '%d.%m.%Y') fdate, t.shift, up.id p_id, up.fio p_name, ua.id a_id, ua.fio a_name, um.id m_id, um.fio m_name, "
                            . "t.organization, t.edition, t.length, r.name roller, lam.name lamination, t.coloring, t.roller_id, t.lamination_id "
                            . "from comiflex t "
                            . "left join user up on t.typographer_id = up.id "
                            . "left join user ua on t.assistant_id = ua.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join roller r on t.roller_id = r.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "where t.date >= '".$date_from->format('Y-m-d')."' and t.date <= '".$date_to->format('Y-m-d')."'";
                    
                    $all = array();
                    $fetcher = new Fetcher($sql);
                    
                    while ($item = $fetcher->Fetch()) {
                        $all[$item['date'].$item['shift']] = $item;
                    }

                    // Список дат и смен
                    $date_diff = $date_to->diff($date_from);
                    $interval = DateInterval::createFromDateString("-1 day");
                    $period = new DatePeriod($date_to, $interval, $date_diff->days);
                    $dateshifts = array();
                    
                    foreach ($period as $date) {
                        $dateshift['date'] = $date;
                        $dateshift['shift'] = 'day';
                        array_push($dateshifts, $dateshift);
                        
                        $dateshift['date'] = $date;
                        $dateshift['shift'] = 'night';
                        array_push($dateshifts, $dateshift);
                    }
                    
                    foreach ($dateshifts as $dateshift) {
                        $key = $dateshift['date']->format('Y-m-d').$dateshift['shift'];
                        $row = array();
                        if(isset($all[$key])) $row = $all[$key];
                        
                        $top = "";
                        if($dateshift['shift'] == 'day') {
                            $top = " class='top'";
                        }
                            
                        echo "<tr>";
                        if($dateshift['shift'] == 'day') {
                            echo "<td$top rowspan='2'>".$weekdays[$dateshift['date']->format('w')]."</td>";
                        }
                        echo "<td$top>".$dateshift['date']->format('Y-m-d').'</td>';
                        echo "<td$top>".($dateshift['shift'] == 'day' ? 'День' : 'Ночь').'</td>';
                        
                        // Печатник
                        echo '<td'.$top.' title="Печатник">';
                        if(IsInRole('admin')) {
                            echo "<form method='post'>";
                            AddHiddenFields($dateshift, $row);
                            echo '<select id="typographer_id" name="typographer_id">';
                            echo '<optgroup>';
                            echo '<option value="">...</option>';
                            foreach ($typographers as $value) {
                                $selected = '';
                                if(isset($row['p_id']) && $row['p_id'] == $value['id']) $selected = " selected = 'selected'";
                                echo "<option$selected value='".$value['id']."'>".$value['fio']."</option>";
                            }
                            echo '</optgroup>';
                            echo "<optgroup label='______________'>";
                            echo "<option value='+'>(добавить)</option>";
                            echo '</optgroup>';
                            echo '</select>';
                            echo '</form>';
                            
                            echo '<form method="post" class="d-none">';
                            AddHiddenFields($dateshift, $row);
                            echo '<div class="input-group">';
                            echo '<input type="text" id="typographer" name="typographer" value="" class="editable" />';
                            echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                            echo '</div>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['p_name'])) echo $row['p_name'];
                        }
                        echo '</td>';
                        
                        // Помощник
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo '<form method="post">';
                            AddHiddenFields($dateshift, $row);
                            echo '<select id="assistant_id" name="assistant_id">';
                            echo '<optgroup>';
                            echo '<option value="">...</option>';
                            foreach ($typographers as $value) {
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
                            AddHiddenFields($dateshift, $row);
                            echo '<div class="input-group">';
                            echo '<input type="text" id="assistant" name="assistant" value="" class="editable" />';
                            echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                            echo '</div>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['a_name'])) echo $row['a_name'];
                        }
                        echo '</td>';
                        
                        // Заказчик
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo '<form method="post">';
                            AddHiddenFields($dateshift, $row);
                            echo '<div class="input-group">';
                            echo '<input type="text" id="organization" name="organization" value="'.(isset($row['organization']) ? htmlentities($row['organization']) : '').'" class="editable" />';
                            echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                            echo '</div>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['organization'])) echo $row['organization'];
                        }
                        echo '</td>';
                        
                        // Тираж
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo '<form method="post">';
                            AddHiddenFields($dateshift, $row);
                            echo '<div class="input-group">';
                            echo '<input type="text" id="edition" name="edition" value="'.(isset($row['edition']) ? htmlentities($row['edition']) : '').'" class="editable" />';
                            echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                            echo '</div>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['edition'])) echo $row['edition'];
                        }
                        echo '</td>';
                        
                        // Метраж
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo '<form method="post">';
                            AddHiddenFields($dateshift, $row);
                            echo '<div class="input-group">';
                            echo '<input type="number" step="1" id="length" name="length" value="'.(isset($row['length']) ? $row['length'] : '').'" class="editable" />';
                            echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                            echo '</div>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['length'])) echo $row['length'];
                        }
                        echo '</td>';
                        
                        // Вал
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo "<form method='post'>";
                            AddHiddenFields($dateshift, $row);
                            echo '<select onchange="javascript: this.form.submit();" id="roller_id" name="roller_id">';
                            echo '<option value="">...</option>';
                            foreach ($rollers as $value) {
                                $selected = '';
                                if(isset($row['roller_id']) && $row['roller_id'] == $value['id']) $selected = " selected = 'selected'";
                                echo "<option$selected value='".$value['id']."'>".$value['name']."</option>";
                            }
                            echo '</select>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['roller'])) echo $row['roller'];
                        }
                        echo '</td>';
                        
                        // Ламинация
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo "<form method='post'>";
                            AddHiddenFields($dateshift, $row);
                            echo '<select onchange="javascript: this.form.submit();" id="lamination_id" name="lamination_id">';
                            echo '<option value="">...</option>';
                            foreach ($laminations as $value) {
                                $selected = '';
                                if(isset($row['lamination_id']) && $row['lamination_id'] == $value['id']) $selected = " selected = 'selected'";
                                echo "<option$selected value='".$value['id']."'>".$value['name']."</option>";
                            }
                            echo '</select>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['lamination'])) echo $row['lamination'];
                        }
                        echo '</td>';
                        
                        // Красочность
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo '<form method="post">';
                            AddHiddenFields($dateshift, $row);
                            echo '<div class="input-group">';
                            echo '<input type="number" step="1" id="coloring" name="coloring" value="'.(isset($row['coloring']) ? $row['coloring'] : '').'" class="editable" />';
                            echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                            echo '</div>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['coloring'])) echo $row['coloring'];
                        }
                        echo '</td>';
                        
                        // Менеджер
                        echo '<td'.$top.'>';
                        if(IsInRole('admin')) {
                            echo "<form method='post'>";
                            AddHiddenFields($dateshift, $row);
                            echo '<select id="manager_id" name="manager_id">';
                            echo '<option value="">...</option>';
                            foreach ($managers as $value) {
                                $selected = '';
                                if(isset($row['m_id']) && $row['m_id'] == $value['id']) $selected = " selected = 'selected'";
                                echo "<option$selected value='".$value['id']."'>".$value['fio']."</option>";
                            }
                            echo '</select>';
                            echo '</form>';
                        }
                        else {
                            if(isset($row['m_name'])) echo $row['m_name'];
                        }
                        echo '</td>';
                        
                        // Удаление смены
                        if(IsInRole('admin')) {
                            echo '<td'.$top.'>';
                            if(isset($row['id'])) {
                                echo "<form method='post'>";
                                echo '<input type="hidden" id="scroll" name="scroll" />';
                                echo "<input type='hidden' id='id' name='id' value='".(isset($row['id']) ? $row['id'] : '')."' />";
                                echo "<input type='hidden' id='date' name='date' value='".$dateshift['date']->format('Y-m-d')."' />";
                                $from = filter_input(INPUT_GET, 'from');
                                if($from !== null) {
                                    echo "<input type='hidden' id='from' name='from' value='$from' />";
                                }
                                $top = filter_input(INPUT_GET, 'to');
                                if($to !== null) {
                                    echo "<input type='hidden' id='to' name='to' value='$to' />";
                                }
                                echo "<button type='submit' id='delete_submit' name='delete_submit' class='btn btn-outline-dark' onclick='javascript:return confirm(\"Действительно удалить?\");'><span class='font-awesome'>&#xf1f8;</span></button>";
                                echo '</form>';
                            }
                            echo '</td>';
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        include '../include/footer.php';
        ?>
        <script>
            $('select[id=typographer_id],select[id=assistant_id],select[id=manager_id]').change(function(){
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