<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        include '../include/restrict_admin.php';
        
        // Валидация формы
        define('ISINVALID', ' is-invalid');
        $form_valid = true;
        $error_message = '';
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['typography_delete_submit'])) {
            if($form_valid) {
                $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                if($conn->connect_error) {
                    die('Ошибка соединения: '.$conn->connect_error);
                }
                
                $sql = "delete from zbs where id=".$_POST['id'];
                
                if ($conn->query($sql) === true) {
                    $period = array();
                    if(isset($_POST['from']) && $_POST['from'] != '')
                        $period['from'] = $_POST['from'];
                    if(isset($_POST['to']) && $_POST['to'] != '')
                        $period['to'] = $_POST['to'];
                    header('Location: '.APPLICATION.'/zbs2/?'. http_build_query($period));
                }
                else {
                    $error_message = $conn->error;
                }
                
                $conn->close();
            }
        }
        
        // Если не указаны параметры from, to, id, переходим к списку рабочих смен
        if(!isset($_GET['from']) || !isset($_GET['to']) || !isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/zbs2/');
        }
        
        // Получение объекта
        $date = '';
        $shift = '';
        $p_name = '';
        $p_first_name = '';
        $p_middle_name = '';
        $organization = '';
        $edition = '';
        $length = '';
        $lamination = '';
        $coloring = '';
        $roller = '';
        $m_name = '';
        $m_first_name = '';
        $m_middle_name = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select t.id, date_format(t.date, '%d.%m.%Y') date, t.shift, "
                . "up.name p_name, up.first_name p_first_name, up.middle_name p_middle_name, "
                . "org.name organization, ed.name edition, "
                . "t.length, lam.name lamination, t.coloring, t.roller, "
                . "um.name m_name, um.first_name m_first_name, um.middle_name m_middle_name "
                . "from zbs t "
                . "left join user up on t.typographer_id = up.id "
                . "left join user um on t.manager_id = um.id "
                . "left join organization org on t.organization_id = org.id "
                . "left join edition ed on t.edition_id = ed.id "
                . "left join lamination lam on t.lamination_id = lam.id "
                . "where t.id=".$_GET['id'];
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $date = $row['date'];
            $shift = $row['shift'];
            $p_name = $row['p_name'];
            $p_first_name = $row['p_first_name'];
            $p_middle_name = $row['p_middle_name'];
            $organization = $row['organization'];
            $edition = $row['edition'];
            $length = $row['length'];
            $lamination = $row['lamination'];
            $coloring = $row['coloring'];
            $roller = $row['roller'];
            $m_name = $row['m_name'];
            $m_first_name = $row['m_first_name'];
            $m_middle_name = $row['m_middle_name'];
        }
        
        $conn->close();
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php
                    if(isset($error_message) && $error_message != '') {
                        echo <<<ERROR
                        <div class="alert alert-danger">$error_message</div>
                        ERROR;
                    }
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>ZBS-2, удаление рабочей смены</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/zbs2/?from=<?=$_GET['from'] ?>&to=<?=$_GET['to'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <h2 class="text-danger">Вы уверены, что хотите удалить эту рабочую смену?</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th>Дата</th>
                            <td><?=$date ?></td>
                            <th>Время</th>
                            <td><?=$shift == 'night' ? 'Ночь' : 'День' ?></td>
                        </tr>
                        <tr>
                            <th>Печатник</th>
                            <td><?=$p_name.' '.(mb_strlen($p_first_name) > 1 ? mb_substr($p_first_name, 0, 1).'.' : $p_first_name).' '.(mb_strlen($p_first_name) > 1 ? mb_substr($p_middle_name, 0, 1).'.' : $p_middle_name) ?></td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Менеджер</th>
                            <td><?=$m_name.' '.(mb_strlen($m_first_name) > 1 ? mb_substr($m_first_name, 0, 1).'.' : $m_first_name).' '.(mb_strlen($m_first_name) > 1 ? mb_substr($m_middle_name, 0, 1).'.' : $m_middle_name) ?></td>
                            <th></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Заказчик</th>
                            <td><?=$organization ?></td>
                            <th>Тираж</th>
                            <td><?=$edition ?></td>
                        </tr>
                        <tr>
                            <th>Метраж</th>
                            <td><?=$length ?></td>
                            <th>Вал</th>
                            <td><?=$roller ?></td>
                        </tr>
                        <tr>
                            <th>Ламинация</th>
                            <td><?=$lamination ?></td>
                            <th>Красочность</th>
                            <td><?=$coloring ?></td>
                        </tr>
                    </table>
                    <form method="post">
                        <input type="hidden" id="from" name="from" value="<?=$_GET['from'] ?>"/>
                        <input type="hidden" id="to" name="to" value="<?=$_GET['to'] ?>"/>
                        <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>"/>
                        <button type="submit" id="typography_delete_submit" name="typography_delete_submit" class="btn btn-outline-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>