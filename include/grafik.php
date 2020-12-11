<?php
class Grafik {
    public function __construct(DateTime $from, DateTime $to) {
        $this->dateFrom = $from;
        $this->dateTo = $to;
    }
    
    private DateTime $dateFrom;
    private DateTime $dateTo;

    public $hasTypographer = false;
    public $sqlTypographers = '';
    public $tableNameTypographer = '';
    public $nnTypographer = '';

    public $hasAssistant = false;
    public $hasOrganization = false;
    public $hasEdition = false;
    public $hasLength = false;
    public $hasRoller = false;
    public $hasLamination = false;
    public $hasColoring = false;
    public $hasManager = false;
    
    
    public $sqlAssistants = '';
    public $sqlRollers = '';
    public $sqlLaminations = '';
    public $sqlManagers = '';
    public $sqlShifts = '';
    
    function ProcessForms() {
        // Выбор печатника
        if($this->tableNameTypographer !== '') {
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
    }

    function ShowPage() {
        if($this->sqlShifts == '') {
            die("Не задан запрос списка смен.");
        }
        ?>
<div class="d-flex justify-content-between mb-2">
    <div class="p-1">
        <h1>ZBS-1</h1>
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
            <?php if($this->hasTypographer): ?><th>Печатник</th><?php endif; ?>
            <?php if($this->hasAssistant): ?><th>Помощник</th><?php endif; ?>
            <?php if($this->hasOrganization): ?><th>Заказчик</th><?php endif; ?>
            <?php if($this->hasEdition): ?><th>Тираж</th><?php endif; ?>
            <?php if($this->hasLength): ?><th>Метраж</th><?php endif; ?>
            <?php if($this->hasRoller): ?><th>Вал</th><?php endif; ?>
            <?php if($this->hasLamination): ?><th>Ламинация</th><?php endif; ?>
            <?php if($this->hasColoring): ?><th>Красочность</th><?php endif; ?>
            <?php if($this->hasManager): ?><th>Менеджер</th><?php endif; ?>
            <?php if(IsInRole('admin')): ?><th></th><?php endif; ?>
        </tr>
    </thead>
    <tbody id="grafik-tbody">
        <?php
        // Список печатников
        if(IsInRole('admin') && ($this->hasTypographer || $this->hasAssistant)) {
            $typographers = (new Grabber($this->sqlTypographers))->result;
        }
        
        // Список валов
        if(IsInRole('admin') && $this->hasRoller) {
            $rollers = (new Grabber($this->sqlRollers))->result;
        }
        
        // Список ламинаций
        if(IsInRole('admin') && $this->hasLamination) {
            $laminations = (new Grabber($this->sqlLaminations))->result;
        }
                    
        // Список менеджеров
        if(IsInRole('admin') && $this->hasManager) {
            $managers = (new Grabber($this->sqlManagers))->result;
        }
        
        // Список рабочих смен
        $all = array();
        $fetcher = new Fetcher($this->sqlShifts);
                    
        while ($item = $fetcher->Fetch()) {
            $all[$item['date'].$item['shift']] = $item;
        }
                    
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
                        
            $top = "";
            if($dateshift['shift'] == 'day') {
                $top = " class='top'";
            }
                        
            echo '<tr>';
            if($dateshift['shift'] == 'day') {
                echo "<td$top rowspan='2'>".$GLOBALS['weekdays'][$dateshift['date']->format('w')].'</td>';
                echo "<td$top rowspan='2'>".$dateshift['date']->format('d.m.Y')."</td>";
            }
            echo "<td$top>".($dateshift['shift'] == 'day' ? 'День' : 'Ночь').'</td>';
            
            // Печатник
            if($this->hasTypographer) {
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
                    echo (isset($row['p_name']) ? $row['p_name'] : '');
                }
                echo '</td>';
            }
            
            // Помощник
            if($this->hasAssistant) {
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
                    echo (isset($row['a_name']) ? $row['a_name'] : '');
                }
                echo '</td>';
            }
            
            // Заказчик
            if($this->hasOrganization) {
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
                    echo (isset($row['organization']) ? $row['organization'] : '');
                }
                echo '</td>';
            }
                    
            // Тираж
            if($this->hasEdition) {
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
                    echo (isset($row['edition']) ? $row['edition'] : '');
                }
                echo '</td>';
            }
            
            // Метраж
            if($this->hasLength) {
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
                    echo (isset($row['length']) ? $row['length'] : '');
                }
                echo '</td>';
            }
                        
            // Вал
            if($this->hasRoller) {
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
                    echo (isset($row['roller']) ? $row['roller'] : '');
                }
                echo '</td>';
            }
                        
            // Ламинация
            if($this->hasLamination) {
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
                    echo (isset($row['lamination']) ? $row['lamination'] : '');
                }
                echo '</td>';
            }
                        
            // Красочность
            if($this->hasColoring) {
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
                    echo (isset($row['coloring']) ? $row['coloring'] : '');
                }
                echo '</td>';
            }
                        
            // Менеджер
            if($this->hasManager) {
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
                    echo (isset($row['m_name']) ? $row['m_name'] : '');
                }
                echo '</td>';
            }
                        
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
                    $to = filter_input(INPUT_GET, 'to');
                    if($to !== null) {
                        echo "<input type='hidden' id='to' name='to' value='$to' />";
                    }
                    echo "<button type='submit' id='delete_submit' name='delete_submit' class='btn btn-outline-dark' onclick='javascript:return confirm(\"Действительно удалить?\");'><span class='font-awesome'>&#xf1f8;</span></button>";
                    echo '</form>';
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php
    }
}
?>