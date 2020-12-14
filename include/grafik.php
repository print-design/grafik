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
    public $sqlUser1 = '';
    public $sqlUser2 = '';
    
    function ProcessForms() {
        //
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
            <?php if($this->user1Name != ''): ?><th><?= $this->user1Name ?></th><?php endif; ?>
            <?php if($this->user2Name != ''): ?><th><?= $this->user2Name ?></th><?php endif; ?>
            <?php if(IsInRole('admin')): ?><th></th><?php endif; ?>
        </tr>
    </thead>
    <tbody id="grafik-tbody">
        <?php
        // Список работников №1
        if(IsInRole('admin') && $this->user1Name != '') {
            $users1 = (new Grabber($this->sqlUser1))->result;
        }
        
        // Список работников №2
        if(IsInRole('admin') && $this->user2Name != '') {
            $users2 = (new Grabber($this->sqlUser2))->result;
        }
        
        // Список рабочих смен
        $all = array();
        $sql = "select ws.id, ws.date date, date_format(ws.date, '%d.%m.%Y') fdate, ws.shift, u1.id u1_id, u1.fio u1_fio, u2.id u2_id, u2.fio u2_fio "
                . "from workshift ws "
                . "left join user u1 on ws.user1_id = u1.id "
                . "left join user u2 on ws.user2_id = u2.id "
                . "where ws.date >= '".$this->dateFrom->format('Y-m-d')."' and ws.date <= '".$this->dateTo->format('Y-m-d')."' and ws.machine_id = ". $this->machineId;
        $fetcher = new Fetcher($sql);
        
        while ($item = $fetcher->Fetch()) {
            $all[$item['date'].$item['shift']] = $item;
        }
        
        // Список дам и смен
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
            echo "<td$top>".($dateshift['shift'] == 'day' ? 'День' : 'Ночь')."</td>";
            
            // Работник №1
            if($this->user1Name != '') {
                echo "<td$top title='".$this->user1Name."'>";
                if(IsInRole('admin')) {
                    echo "<form method='post'>";
                    AddHiddenFields($dateshift, $row);
                    echo "<select id='user1_id' name='user1_id'>";
                    echo '<optgroup>';
                    echo '<option value="">...</option>';
                    foreach ($users1 as $value) {
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
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php
    }
}
?>