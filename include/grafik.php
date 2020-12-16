<?php
class Grafik {
    public function __construct(DateTime $from, DateTime $to, $machine_id) {
        $this->dateFrom = $from;
        $this->dateTo = $to;
        $this->machineId = $machine_id;
    }
    
    private DateTime $dateFrom;
    private DateTime $dateTo;
    private $machineId;
    
    public $user1Name = '';
    public $user2Name = '';
    public $userRole = 0;
    
    public $hasEdition = false;
    public $hasOrganization = false;
    public $hasLength = false;
    public $hasRoller = false;
    public $hasLamination = false;
    public $hasColoring = false;
    public $hasManager = false;
    public $hasComment = false;
    
    public $error_message = '';
            
    function ProcessForms() {
        // Выбор работника 1
        $user1_id = filter_input(INPUT_POST, 'user1_id');
        if($user1_id !== null) {
            if($user1_id == '') $user1_id = "NULL";
            $sql = '';
            $id = filter_input(INPUT_POST, 'id');
            
            if($id !== null) {
                $this->error_message = (new Executer("update workshift set user1_id=$user1_id where id=$id"))->error;
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into workshift (date, machine_id, shift, user1_id) values ('$date', $this->machineId, '$shift', $user1_id)";
                $ws_executer = new Executer($sql);
                $this->error_message = $ws_executer->error;
                $workshift_id = $ws_executer->insert_id;
                
                if($workshift_id > 0) {
                    $this->error_message = (new Executer("insert into edition (workshift_id) values ($workshift_id)"))->error;
                }
            }
        }
        
        // Создание нового работника 1
        $user1 = filter_input(INPUT_POST, 'user1');
        if($user1 !== null) {
            $user1 = addslashes($user1);
            $u_executer = new Executer("insert into user (fio, username) values ('$user1', CURRENT_TIMESTAMP())");
            $this->error_message = $u_executer->error;
            $user1_id = $u_executer->insert_id;
            
            if($user1_id > 0) {
                $role_id = $this->userRole;
                $r_executer = new Executer("insert into user_role (user_id, role_id) values ($user1_id, $role_id)");
                $this->error_message = $r_executer->error;
                
                if($this->error_message == '') {
                    $sql = '';
                    $id = filter_input(INPUT_POST, 'id');
                    
                    if($sql != null) {
                        $this->error_message = (new Executer("update workshift set user1_id=$user1_id where id=$id"))->error;
                    }
                    else {
                        $date = filter_input(INPUT_POST, 'date');
                        $shift = filter_input(INPUT_POST, 'shift');
                        $sql = "insert into workshift (date, machine_id, shift, user1_id) values ('$date', $this->machineId, '$shift', $user1_id)";
                        $ws_executer = new Executer($sql);
                        $this->error_message = $ws_executer->error;
                        $workshift_id = $ws_executer->insert_id;
                        
                        if($workshift_id > 0) {
                            $this->error_message = (new Executer("insert into edition (workshift_id) values ($workshift_id)"))->error;
                        }
                    }
                }
            }
        }
        
        // Выбор работника 2
        $user2_id = filter_input(INPUT_POST, 'user2_id');
        if($user2_id !== null) {
            if($user2_id == '') $user2_id = "NULL";
            $sql = '';
            $id = filter_input(INPUT_POST, 'id');
            
            if($id != null) {
                $this->error_message = (new Executer("update workshift set user2_id=$user2_id where id=$id"))->error;
            }
            else {
                $date = filter_input(INPUT_POST, 'date');
                $shift = filter_input(INPUT_POST, 'shift');
                $sql = "insert into workshift (date, machine_id, shift, user2_id) values ('$date', $this->machineId, '$shift', $user2_id)";
                $ws_executer = new Executer($sql);
                $this->error_message = $ws_executer->error;
                $workshift_id = $ws_executer->insert_id;
                
                if($workshift_id > 0) {
                    $this->error_message = (new Executer("insert into edition (workshift_id) values ($workshift_id)"))->error;
                }
            }
        }
        
        // Создание нового работника 2
        $user2 = filter_input(INPUT_POST, 'user2');
        if($user2 !== null) {
            $user2 = addslashes($user2);
            $u_executer = new Executer("insert into user (fio, username) values ('$user2', CURRENT_TIMESTAMP())");
            $this->error_message = $u_executer->error;
            $user2_id = $u_executer->insert_id;
            
            if($user2_id > 0) {
                $role_id = $this->userRole;
                $r_executer = new Executer("insert into user_role (user_id, role_id) values ($user2_id, $role_id)");
                $this->error_message = $r_executer->error;
                
                if($r_executer->error == '') {
                    $sql = '';
                    $id = filter_input(INPUT_POST, 'id');
                    
                    if($id !== null) {
                        $this->error_message = (new Executer("update workshift set user2_id=$user2_id where id=$id"))->error;
                    }
                    else {
                        $date = filter_input(INPUT_POST, 'date');
                        $shift = filter_input(INPUT_POST, 'shift');
                        $sql = "insert into workshift (date, machine_id, shift, user2_id) values ('$date', $this->machineId, '$shift', $user2_id)";
                        $ws_executer = new Executer($sql);
                        $this->error_message = $ws_executer->error;
                        $workshift_id = $ws_executer->insert_id;
                        
                        if($workshift_id > 0) {
                            $this->error_message = (new Executer("insert into edition (workshift_id) values ($workshift_id)"))->error;
                        }
                    }
                }
            }
        }
        
        // Создание рабочей смены
        $create_shift_submit = filter_input(INPUT_POST, 'create_shift_submit');
        if($create_shift_submit !== null) {
            $this->error_message = 'ТЕСТОВАЯ ОШИБКА';
        }
    }

    function ShowPage() {
        ?>
<div class="d-flex justify-content-between mb-2">
    <div class="p-1">
        <h1>Comiflex</h1>
    </div>
    <div class="p-1">
        <?php if(IsInRole('admin')): ?>
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
        <?php endif; ?>
    </div>
</div>
<table class="table table-bordered typography">
    <thead id="grafik-thead">
        <tr>
            <th></th>
            <th>Дата</th>
            <th>Смена</th>
            <?php
            if($this->user1Name != '') echo '<th>'.$this->user1Name.'</th>';
            if($this->user2Name != '') echo '<th>'.$this->user2Name.'</th>';
            if(IsInRole('admin')) echo '<th></th>';
            if($this->hasEdition) echo '<th>Тираж</th>';
            if($this->hasOrganization) echo '<th>Заказчик</th>';
            if($this->hasLength) echo '<th>Метраж</th>';
            if($this->hasRoller) echo '<th>Вал</th>';
            if($this->hasLamination) echo '<th>Ламинация</th>';
            if($this->hasColoring) echo '<th>Красочность</th>';
            if($this->hasManager) echo '<th>Менеджер</th>'; 
            if($this->hasComment) echo '<th>Комментарий</th>';
            if(IsInRole('admin')) echo '<th></th>';
            ?>
        </tr>
    </thead>
    <tbody id="grafik-tbody">
        <?php
        // Список работников №1
        if(IsInRole('admin') && $this->user1Name != '') {
            $users1 = (new Grabber('select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = '. $this->userRole.' order by u.fio'))->result;
        }
        
        // Список работников №2
        if(IsInRole('admin') && $this->user2Name != '') {
            $users2 = (new Grabber('select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = '. $this->userRole.' order by u.fio'))->result;
        }
        
        // Список рабочих смен
        $all = array();
        $sql = "select ws.id, ws.date date, date_format(ws.date, '%d.%m.%Y') fdate, ws.shift, u1.id u1_id, u1.fio u1_fio, u2.id u2_id, u2.fio u2_fio, "
                . "(select count(id) from edition where workshift_id=ws.id) editions_count "
                . "from workshift ws "
                . "left join user u1 on ws.user1_id = u1.id "
                . "left join user u2 on ws.user2_id = u2.id "
                . "where ws.date >= '".$this->dateFrom->format('Y-m-d')."' and ws.date <= '".$this->dateTo->format('Y-m-d')."' and ws.machine_id = ". $this->machineId;
        $fetcher = new Fetcher($sql);
        
        while ($item = $fetcher->Fetch()) {
            $all[$item['date'].$item['shift']] = $item;
        }
        
        // Список тиражей
        $all_editions = [];
        $sql = "select ws.date, ws.shift, e.id, e.workshift_id, e.name, e.organization, e.length, e.coloring, "
                . "e.roller_id, r.name roller, "
                . "e.lamination_id, lam.name lamination, "
                . "e.manager_id, m.fio manager "
                . "from edition e "
                . "left join roller r on e.roller_id = r.id "
                . "left join lamination lam on e.lamination_id = lam.id "
                . "left join user m on e.manager_id = m.id "
                . "inner join workshift ws on e.workshift_id = ws.id "
                . "where ws.date >= '".$this->dateFrom->format('Y-m-d')."' and ws.date <= '".$this->dateTo->format('Y-m-d')."' and ws.machine_id = ". $this->machineId;
        
        $fetcher = new Fetcher($sql);
        
        while ($item = $fetcher->Fetch()) {
            if(!array_key_exists($item['date'], $all_editions) || !array_key_exists($item['shift'], $all_editions['date'])) $all_editions[$item['date']][$item['shift']] = [];
            array_push($all_editions[$item['date']][$item['shift']], $item);
        }
        
        foreach ($all_editions as $dates) {
            if(!array_key_exists('day', $dates)) {
                $dates['day'] = array();
            }
            if(!array_key_exists('night', $dates)) $dates['night'] = array();
        }
        
        print_r($all_editions['day']);
        print_r($all_editions['night']);
        
        // Список дат и смен
        $date_diff = $this->dateTo->diff($this->dateFrom);
        $interval = DateInterval::createFromDateString("-1 day");
        $period = new DatePeriod($this->dateTo, $interval, $date_diff->days);
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
            
            $editions = array();
            if(isset($row['id']) && array_key_exists($row['id'], $all_editions)) {
                $editions = $all_editions[$row['id']];
            }
            
            $top = "";
            if($dateshift['shift'] == 'day') {
                $top = " class='top'";
            }
            
            echo '<tr>';
            if($dateshift['shift'] == 'day') {
                echo "<td$top rowspan='2'>".$GLOBALS['weekdays'][$dateshift['date']->format('w')].'</td>';
                echo "<td$top rowspan='2'>".$dateshift['date']->format('d.m.Y')."</td>";
            }
            echo "<td$top>".($dateshift['shift'] == 'day' ? 'День' : 'Ночь')."</td>";
            
            // Работник №1
            if($this->user1Name != '') {
                echo "<td$top title='".$this->user1Name."'>";
                if(IsInRole('admin')) {
                    
                    
                    if(isset($row['id']) && array_key_exists($row['id'], $all_editions)) {
                        print_r($all_editions[$row['id']]);
                    }
                    
                    
                    echo "<form method='post'>";
                    AddHiddenFields($dateshift, $row);
                    echo "<select id='user1_id' name='user1_id'>";
                    echo '<optgroup>';
                    echo '<option value="">...</option>';
                    foreach ($users1 as $value) {
                        $selected = '';
                        if(isset($row['u1_id']) && $row['u1_id'] == $value['id']) $selected = " selected = 'selected'";
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
                    echo '<input type="text" id="user1" name="user1" value="" class="editable" />';
                    echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                    echo '</div>';
                    echo '</form>';
                }
                else {
                    echo (isset($row['u1_fio']) ? $row['u1_fio'] : '');
                }
                echo '</td>';
            }
            
            // Работник №2
            if($this->user2Name != '') {
                echo "<td$top title='".$this->user2Name."'>";
                if(IsInRole('admin')) {
                    echo "<form method='post'>";
                    AddHiddenFields($dateshift, $row);
                    echo "<select id='user2_id' name='user2_id'>";
                    echo '<optgroup>';
                    echo '<option value="">...</option>';
                    foreach ($users2 as $value) {
                        $selected = '';
                        if(isset($row['u2_id']) && $row['u2_id'] == $value['id']) $selected = " selected = 'selected'";
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
                    echo '<input type="text" id="user2" name="user2" value="" class="editable" />';
                    echo '<div class="input-group-append d-none"><button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf0c7;</span></button></div>';
                    echo '</div>';
                    echo '</form>';
                }
                else {
                    echo (isset($row['u2_fio']) ? $row['u2_fio'] : '');
                }
                echo '</td>';
            }
            
            // Добавление смены
            if(IsInRole('admin')) {
                echo "<td$top>";
                echo "<form method='post'>";
                echo '<input type="hidden" id="scroll" name="scroll" />';
                echo "<input type='hidden' id='date' name='date' value='".$dateshift['date']->format('Y-m-d')."' />";
                echo "<input type='hidden' id='shift' name='shifft' value='".$dateshift['shift']."' />";
                $from = filter_input(INPUT_GET, 'from');
                if($from !== null) {
                    echo "<input type='hidden' id='from' name='from' value='$from' />";
                }
                $to = filter_input(INPUT_GET, 'to');
                if($to !== null) {
                    echo "<input type='hidden' id='to' name='to' value='$to' />";
                }
                echo "<button type='submit' id='create_shift_submit' name='create_shift_submit' class='btn btn-outline-dark' title='Добавить тираж'><span class='font-awesome'>&#xf067;</span></button>";
                echo '</form>';
                echo '</td>';
            }
            
            // Смены
            if($this->hasEdition) echo "<td$top></td>";
            if($this->hasOrganization) echo "<td$top></td>";
            if($this->hasLength) echo "<td$top></td>";
            if($this->hasRoller) echo "<td$top></td>";
            if($this->hasLamination) echo "<td$top></td>";
            if($this->hasColoring) echo "<td$top></td>";
            if($this->hasManager) echo "<td$top></td>";
            if($this->hasComment) echo "<td$top></td>";
            if(IsInRole('admin')) echo "<td$top></td>";
            
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php
    }
}
?>