<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        
        $nn = 1;
        
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
                    <h1>ZBS-1</h1>
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
                        <th>Заказчик</th>
                        <th>Тираж</th>
                        <th>Метраж</th>
                        <th>Вал</th>
                        <th>Ламинация</th>
                        <th>Красочность</th>
                        <th>Менеджер</th>
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
                            . "up.last_name p_last_name, up.first_name p_first_name, up.middle_name p_middle_name, "
                            . "org.name organization, ed.name edition, t.length, lam.name lamination, t.coloring, t.roller, "
                            . "um.last_name m_last_name, um.first_name m_first_name, um.middle_name m_middle_name "
                            . "from date_ranges dr left join zbs t "
                            . "left join user up on t.typographer_id = up.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join organization org on t.organization_id = org.id "
                            . "left join edition ed on t.edition_id = ed.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "on t.date = dr.date and t.shift = 'day' and t.nn = ".$nn." "
                            . "union "
                            . "select t.id, dr.date date, date_format(dr.date, '%d.%m.%Y') fdate, 'night' shift, "
                            . "up.last_name p_last_name, up.first_name p_first_name, up.middle_name p_middle_name, "
                            . "org.name organization, ed.name edition, t.length, lam.name lamination, t.coloring, t.roller, "
                            . "um.last_name m_last_name, um.first_name m_first_name, um.middle_name m_middle_name "
                            . "from date_ranges dr left join zbs t "
                            . "left join user up on t.typographer_id = up.id "
                            . "left join user um on t.manager_id = um.id "
                            . "left join organization org on t.organization_id = org.id "
                            . "left join edition ed on t.edition_id = ed.id "
                            . "left join lamination lam on t.lamination_id = lam.id "
                            . "on t.date = dr.date and t.shift = 'night' and t.nn = ".$nn." "
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
                            echo '<td'.$top.'>'.$row['p_last_name'].' '.(mb_strlen($row['p_first_name']) > 1 ? mb_substr($row['p_first_name'], 0, 1).'.' : $row['p_first_name']).' '.(mb_strlen($row['p_middle_name']) > 1 ? mb_substr($row['p_middle_name'], 0, 1).'.' : $row['p_middle_name']).'</td>';
                            echo '<td'.$top.'>'.$row['organization'].'</td>';
                            echo '<td'.$top.'>'.$row['edition'].'</td>';
                            echo '<td'.$top.'>'.$row['length'].'</td>';
                            echo '<td'.$top.'>'.$row['roller'].'</td>';
                            echo '<td'.$top.'>'.$row['lamination'].'</td>';
                            echo '<td'.$top.'>'.$row['coloring'].'</td>';
                            echo '<td'.$top.'>'.$row['m_last_name'].' '.(mb_strlen($row['m_first_name']) > 1 ? mb_substr($row['m_first_name'], 0, 1).'.' : $row['m_first_name']).' '.(mb_strlen($row['m_middle_name']) > 1 ? mb_substr($row['m_middle_name'], 0, 1).'.' : $row['m_middle_name']).'</td>';
                            
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