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
        
        $typographer_id_valid = '';
        $manager_id_valid = '';
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['typography_edit_submit'])) {
            if($form_valid) {
                $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                if($conn->connect_error) {
                    die('Ошибка соединения: '.$conn->connect_error);
                }
                
                $id = $_POST['id'];
                $typographer_id = $_POST['typographer_id'];
                $assistant_id = $_POST['assistant_id'] == '' ? 'NULL' : $_POST['assistant_id'];
                $organization_id = $_POST['organization_id'] == '' ? 'NULL' : $_POST['organization_id'];
                $edition_id = $_POST['edition_id'] == '' ? 'NULL' : $_POST['edition_id'];
                $length = $_POST['length'] == '' ? 'NULL' : $_POST['length'];
                $lamination_id = $_POST['lamination_id'] == '' ? 'NULL' : $_POST['lamination_id'];
                $coloring = $_POST['coloring'] == '' ? 'NULL' : $_POST['coloring'];
                $roller = $_POST['roller'] == '' ? 'NULL' : $_POST['roller'];
                $manager_id = $_POST['manager_id'];
                
                $sql = "update comiflex set typographer_id=$typographer_id, assistant_id=$assistant_id, organization_id=$organization_id, edition_id=$edition_id, length=$length, lamination_id=$lamination_id, coloring=$coloring, roller=$roller, manager_id=$manager_id where id=$id";
                
                if ($conn->query($sql) === true) {
                    $period = array();
                    if(isset($_POST['from']) && $_POST['from'] != '')
                        $period['from'] = $_POST['from'];
                    if(isset($_POST['to']) && $_POST['to'] != '')
                        $period['to'] = $_POST['to'];
                    header('Location: '.APPLICATION.'/comiflex/?'. http_build_query($period));
                }
                else {
                    $error_message = $conn->error;
                }
                
                $conn->close();
            }
        }
        
        // Если не указаны параметры from, to, id, переходим к списку рабочих смен
        if(!isset($_GET['from']) || !isset($_GET['to']) || !isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/comiflex/');
        }
        
        // Получение объекта
        $date = '';
        $shift = '';
        $typographer_id = '';
        $assistant_id = '';
        $organization_id = '';
        $edition_id = '';
        $length = '';
        $lamination_id = '';
        $coloring = '';
        $roller = '';
        $manager_id = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select t.id, date_format(t.date, '%d.%m.%Y') date, t.shift, t.typographer_id, t.assistant_id, "
                . "t.organization_id, t.edition_id, "
                . "t.length, t.lamination_id, t.coloring, t.roller, t.manager_id "
                . "from comiflex t "
                . "where t.id=".$_GET['id'];
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $date = $row['date'];
            $shift = $row['shift'];
            $typographer_id = $row['typographer_id'];
            $assistant_id = $row['assistant_id'];
            $organization_id = $row['organization_id'];
            $edition_id = $row['edition_id'];
            $length = $row['length'];
            $lamination_id = $row['lamination_id'];
            $coloring = $row['coloring'];
            $roller = $row['roller'];
            $manager_id = $row['manager_id'];
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
                            <h1>Comiflex, редактирование рабочей смены</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/comiflex/?from=<?=$_GET['from'] ?>&to=<?=$_GET['to'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Дата</th>
                            <td><?=$date ?></td>
                        </tr>
                        <tr>
                            <th>Время</th>
                            <td><?=$shift == 'night' ? 'Ночь' : 'День' ?></td>
                        </tr>
                    </table>
                    <form method="post">
                        <input type="hidden" id="from" name="from" value="<?=$_GET['from'] ?>"/>
                        <input type="hidden" id="to" name="to" value="<?=$_GET['to'] ?>"/>
                        <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>"/>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="typographer_id">Печатник</label>
                                    <select id="typographer_id" name="typographer_id" class="form-control" required="required">
                                        <option value="">...</option>
                                        <?php
                                        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                        if($conn->connect_error) {
                                            die('Ошибка соединения: ' . $conn->connect_error);
                                        }
                                        
                                        $sql = "select u.id, u.name, u.first_name, u.middle_name from user_role ur "
                                                . "inner join user u on ur.user_id = u.id "
                                                . "inner join role r on ur.role_id = r.id "
                                                . "where r.name = 'typographer' "
                                                . "order by u.name";
                                        
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['typographer_id']) && $_POST['typographer_id'] == $row['id'] ? " selected='selected'" : "";
                                                if($selected == '' && $typographer_id == $row['id']) $selected = " selected='selected'";
                                                echo "<option value='".$row['id']."'".$selected.">".$row["name"].' '.(mb_strlen($row['first_name']) > 1 ? mb_substr($row['first_name'], 0, 1).'.' : $row['first_name']).' '.(mb_strlen($row['first_name']) > 1 ? mb_substr($row['middle_name'], 0, 1).'.' : $row['middle_name'])."</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Печатник обязательно</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="assistant_id">Помощник</label>
                                    <select id="assistant_id" name="assistant_id" class="form-control">
                                        <option value="">...</option>
                                        <?php
                                        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                        if($conn->connect_error) {
                                            die('Ошибка соединения: ' . $conn->connect_error);
                                        }
                                        
                                        $sql = "select u.id, u.name, u.first_name, u.middle_name from user_role ur "
                                                . "inner join user u on ur.user_id = u.id "
                                                . "inner join role r on ur.role_id = r.id "
                                                . "where r.name = 'typographer' "
                                                . "order by u.name";
                                        
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assistant_id']) && $_POST['assistant_id'] == $row['id'] ? " selected='selected'" : "";
                                                if($selected == '' && $assistant_id == $row['id']) $selected = " selected='selected'";
                                                echo "<option value='".$row['id']."'".$selected.">".$row["name"].' '.(mb_strlen($row['first_name']) > 1 ? mb_substr($row['first_name'], 0, 1).'.' : $row['first_name']).' '.(mb_strlen($row['first_name']) > 1 ? mb_substr($row['middle_name'], 0, 1).'.' : $row['middle_name'])."</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="manager_id">Менеджер</label>
                                    <select id="manager_id" name="manager_id" class="form-control" required="required">
                                        <option value="">...</option>
                                        <?php
                                        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                        if($conn->connect_error) {
                                            die('Ошибка соединения: ' . $conn->connect_error);
                                        }
                                        
                                        $sql = "select u.id, u.name, u.first_name, u.middle_name from user_role ur "
                                                . "inner join user u on ur.user_id = u.id "
                                                . "inner join role r on ur.role_id = r.id "
                                                . "where r.name = 'manager' "
                                                . "order by u.name";
                                        
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['manager_id']) && $_POST['manager_id'] == $row['id'] ? " selected='selected'" : "";
                                                if($selected == '' && $manager_id == $row['id']) $selected = " selected='selected'";
                                                echo "<option value='".$row['id']."'".$selected.">".$row["name"].' '.(mb_strlen($row['first_name']) > 1 ? mb_substr($row['first_name'], 0, 1).'.' : $row['first_name']).' '.(mb_strlen($row['first_name']) > 1 ? mb_substr($row['middle_name'], 0, 1).'.' : $row['middle_name'])."</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Менеджер обязательно</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="organization_id">Заказчик</label>
                                    <select id="organization_id" name="organization_id" class="form-control">
                                        <option value="">...</option>
                                        <?php
                                        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                        if($conn->connect_error) {
                                            die('Ошибка соединения: ' . $conn->connect_error);
                                        }
                                        
                                        $sql = "select id, name from organization order by name";
                                        
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['organization_id']) && $_POST['organization_id'] == $row['id'] ? " selected='selected'" : "";
                                                if($selected == '' && $organization_id == $row['id']) $selected = " selected='selected'";
                                                echo "<option value='".$row['id']."'".$selected.">".$row["name"]."</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="edition_id">Тираж</label>
                                    <select id="edition_id" name="edition_id" class="form-control">
                                        <option value="">...</option>
                                        <?php
                                        if(isset($organization_id) && $organization_id != '') {
                                            $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                            if($conn->connect_error) {
                                                die('Ошибка соединения: ' . $conn->connect_error);
                                            }
                                            
                                            $sql = "select id, name from edition where organization_id = $organization_id order by name";
                                            $result = $conn->query($sql);
                                            if($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = isset($_POST['edition_id']) && $_POST['edition_id'] == $row['id'] ? " selected='selected'" : "";
                                                    if($selected == '' && $edition_id == $row['id']) $selected = " selected='selected'";
                                                    echo "<option value='".$row['id']."'".$selected.">".$row['name']."</option>";
                                                }
                                            }
                                            
                                            $conn->close();
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="length">Метраж</label>
                                    <input type="number" step="1" id="length" name="length" class="form-control" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['length']) ? $_POST['length'] : $length ?>"/>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="roller">Вал</label>
                                    <input type="number" step="1" id="roller" name="roller" class="form-control" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roller']) ? $_POST['roller'] : $roller ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="lamination_id">Ламинация</label>
                                    <select id="lamination_id" name="lamination_id" class="form-control">
                                        <option value="">...</option>
                                        <?php
                                        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                        if($conn->connect_error) {
                                            die('Ошибка соединения: ' . $conn->connect_error);
                                        }
                                        
                                        $sql = "select id, name from lamination where common = 1 order by sort";
                                        
                                        $result = $conn->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $selected = $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['organization_id']) && $_POST['organization_id'] == $row['id'] ? " selected='selected'" : "";
                                                if($selected == '' && $lamination_id == $row['id']) $selected = " selected='selected'";
                                                echo "<option value='".$row['id']."'".$selected.">".$row["name"]."</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="coloring">Красочность</label>
                                    <input type="number" step="1" id="coloring" name="coloring" class="form-control" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['coloring']) ? $_POST['coloring'] : $coloring ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="typography_edit_submit" name="typography_edit_submit" class="btn btn-outline-dark">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
        <script>
            $("select#organization_id").change(function() {
                var selectedValue = this.value;
                
                $.ajax({
                    url: '<?=APPLICATION ?>/ajax/edition.php',
                    type: 'GET',
                    data: {organization_id: selectedValue},
                    success: function(data, status){
                        if(status == 'success') {
                            $('select#edition_id').html(data);
                        }
                        else {
                            alert('Обращение к edition.php вернуло ошибочный результат');
                        }
                    },
                    error: function(){
                        alert('Ошибка при обращении к edition.php');
                    }
                })
            });
        </script>
    </body>
</html>