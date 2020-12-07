<?php
include '../include/topscripts.php';
?>
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
        
        $role_id_valid = '';
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_user_role_submit'])) {
            if($_POST['role_id'] == '') {
                $role_id_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($form_valid) {
                $user_id = $_POST['user_id'];
                $role_id = $_POST['role_id'];
                $sql = "insert into user_role (user_id, role_id) values ($user_id, $role_id)";
                $error_message = ExecuteSql($sql);
            }
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_role_submit'])) {
            $user_id = $_POST['user_id'];
            $role_id = $_POST['role_id'];
            $sql = "delete from user_role where user_id = $user_id and role_id = $role_id";
            $error_message = ExecuteSql($sql);
        }
        
        // Если нет параметра id, переход к списку
        if(!isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/user/');
        }
        
        // Получение объекта
        $username = '';
        $fio = '';
        
        $comiflex_typographer = 0;
        $comiflex_assistant = 0;
        $comiflex_manager = 0;
        $zbs1_typographer = 0;
        $zbs1_manager = 0;
        $zbs2_typographer = 0;
        $zbs2_manager = 0;
        $zbs3_typographer = 0;
        $zbs3_manager = 0;
        $atlas_typographer = 0;
        $atlas_manager = 0;
        $lamination_laminator1 = 0;
        $lamination_laminator2 = 0;
        $lamination_manager = 0;
        $cutting_cutter = 0;
        $cutting_manager = 0;
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select u.username, u.fio, "
                . "(select count(id) from comiflex where typographer_id = u.id) comiflex_typographer, "
                . "(select count(id) from comiflex where assistant_id = u.id) comiflex_assistant, "
                . "(select count(id) from comiflex where manager_id = u.id) comiflex_manager, "
                . "(select count(id) from zbs where nn = 1 and typographer_id = u.id) zbs1_typographer, "
                . "(select count(id) from zbs where nn = 1 and manager_id = u.id) zbs1_manager, "
                . "(select count(id) from zbs where nn = 2 and typographer_id = u.id) zbs2_typographer, "
                . "(select count(id) from zbs where nn = 2 and manager_id = u.id) zbs2_manager, "
                . "(select count(id) from zbs where nn = 3 and typographer_id = u.id) zbs3_typographer, "
                . "(select count(id) from zbs where nn = 3 and manager_id = u.id) zbs3_manager, "
                . "(select count(id) from zbs where nn = 99 and typographer_id = u.id) atlas_typographer, "
                . "(select count(id) from zbs where nn = 99 and manager_id = u.id) atlas_manager, "
                . "(select count(id) from laminators where laminator1_id = u.id) lamination_laminator1, "
                . "(select count(id) from laminators where laminator2_id = u.id) lamination_laminator2, "
                . "(select count(id) from laminators where manager_id = u.id) lamination_manager, "
                . "(select count(id) from cutters where cutter_id = u.id) cutting_cutter, "
                . "(select count(id) from cutters where manager_id = u.id) cutting_manager "
                . "from user u where u.id = ".$_GET['id'];
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        
        mysqli_query($conn, 'set names utf8');
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $username = $row['username'];
            $fio = $row['fio'];
            $comiflex_typographer = $row['comiflex_typographer'];
            $comiflex_assistant = $row['comiflex_assistant'];
            $comiflex_manager = $row['comiflex_manager'];
            $zbs1_typographer = $row['zbs1_typographer'];
            $zbs1_manager = $row['zbs1_manager'];
            $zbs2_typographer = $row['zbs2_typographer'];
            $zbs2_manager = $row['zbs2_manager'];
            $zbs3_typographer = $row['zbs3_typographer'];
            $zbs3_manager = $row['zbs3_manager'];
            $atlas_typographer = $row['atlas_typographer'];
            $atlas_manager = $row['atlas_manager'];
            $lamination_laminator1 = $row['lamination_laminator1'];
            $lamination_laminator2 = $row['lamination_laminator2'];
            $lamination_manager = $row['lamination_manager'];
            $cutting_cutter = $row['cutting_cutter'];
            $cutting_manager = $row['cutting_manager'];
        }
        $conn->close();
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
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1><?=$username ?></h1>
                        </div>
                        <div class="p-1">
                            <div class="btn-group">
                                <a href="<?=APPLICATION ?>/user/" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;К списку</a>
                                <a href="<?=APPLICATION ?>/user/edit.php?id=<?=$_GET['id'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf044;</span>&nbsp;Редактировать</a>
                                <?php
                                $shifts_count = intval($comiflex_typographer) +
                                        intval($comiflex_assistant) +
                                        intval($comiflex_manager) +
                                        intval($zbs1_typographer) +
                                        intval($zbs1_manager) +
                                        intval($zbs2_typographer) +
                                        intval($zbs2_manager) +
                                        intval($zbs3_typographer) +
                                        intval($zbs3_manager) +
                                        intval($atlas_typographer) +
                                        intval($atlas_manager) +
                                        intval($lamination_laminator1) +
                                        intval($lamination_laminator2) +
                                        intval($lamination_manager) +
                                        intval($cutting_cutter) +
                                        intval($cutting_manager);
                                if($shifts_count === 0 && $_COOKIE[USERNAME] != $username) :
                                ?>
                                <a href="<?=APPLICATION ?>/user/delete.php?id=<?=$_GET['id'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf1f8;</span>&nbsp;Удалить</a>
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>ФИО</th>
                            <td><?=$fio ?></td>
                        </tr>
                        <tr>
                            <th>Логин</th>
                            <td><?=$username ?></td>
                        </tr>
                        <tr>
                            <th>Comiflex, печатник</th>
                            <td><?=$comiflex_typographer ?></td>
                        </tr>
                        <tr>
                            <th>Comiflex, ассистент</th>
                            <td><?=$comiflex_assistant ?></td>
                        </tr>
                        <tr>
                            <th>Comiflex, менеджер</th>
                            <td><?=$comiflex_manager ?></td>
                        </tr>
                        <tr>
                            <th>ZBS-1, печатник</th>
                            <td><?=$zbs1_typographer ?></td>
                        </tr>
                        <tr>
                            <th>ZBS-1, менеджер</th>
                            <td><?=$zbs1_manager ?></td>
                        </tr>
                        <tr>
                            <th>ZBS-2, печатник</th>
                            <td><?=$zbs2_typographer ?></td>
                        </tr>
                        <tr>
                            <th>ZBS-2, менеджер</th>
                            <td><?=$zbs2_manager ?></td>
                        </tr>
                        <tr>
                            <th>ZBS-3, печатник</th>
                            <td><?=$zbs3_typographer ?></td>
                        </tr>
                        <tr>
                            <th>ZBS-3, менеджер</th>
                            <td><?=$zbs3_manager ?></td>
                        </tr>
                        <tr>
                            <th>Атлас, печатник</th>
                            <td><?=$atlas_typographer ?></td>
                        </tr>
                        <tr>
                            <th>Атлас, менеджер</th>
                            <td><?=$atlas_manager ?></td>
                        </tr>
                        <tr>
                            <th>Ламинация, ламинаторщик 1</th>
                            <td><?=$lamination_laminator1 ?></td>
                        </tr>
                        <tr>
                            <th>Ламинация, ламинаторщик 2</th>
                            <td><?=$lamination_laminator2 ?></td>
                        </tr>
                        <tr>
                            <th>Ламинация, менеджер</th>
                            <td><?=$lamination_manager ?></td>
                        </tr>
                        <tr>
                            <th>Резка, резчик</th>
                            <td><?=$cutting_cutter ?></td>
                        </tr>
                        <tr>
                            <th>Резка, менеджер</th>
                            <td><?=$cutting_manager ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h2>Роли</h2>
                        </div>
                        <div class="p-1">
                            <form method="post" class="form-inline">
                                <input type="hidden" id="user_id" name="user_id" value="<?=$_GET['id'] ?>"/>
                                <div class="form-group">
                                    <select id="role_id" name="role_id" class="form-control<?=$role_id_valid ?>" required="required">
                                        <option value="">...</option>
                                        <?php
                                        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                                        
                                        if($conn->connect_error) {
                                            die('Ошибка соединения: ' . $conn->connect_error);
                                        }
                                        
                                        $sql = "select id, local_name from role where id not in (select role_id from user_role where user_id = ".$_GET['id'].") ";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $local_name = $row['local_name'];
                                                echo "<option value='$id'>$local_name</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">*</div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control" id="create_user_role_submit" name="create_user_role_submit">
                                        <span class="font-awesome">&#xf067;</span>&nbsp;Добавить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                            $sql = "select ur.user_id, ur.role_id, r.local_name from role r inner join user_role ur on r.id = ur.role_id where ur.user_id = ".$_GET['id'];
                            
                            if($conn->connect_error) {
                                die('Ошибка соединения: ' . $conn->connect_error);
                            }
                            
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $user_id = $row['user_id'];
                                    $role_id = $row['role_id'];
                                    $local_name = $row['local_name'];
                                    echo <<<ROLE
                                    <tr>
                                        <td>$local_name</td>
                                        <td style='width:10%';>
                                            <form method='post'>
                                                <input type='hidden' id='user_id' name='user_id' value='$user_id' />
                                                <input type='hidden' id='role_id' name='role_id' value='$role_id' />
                                                <button type='submit' id='delete_user_role_submit' name='delete_user_role_submit' class='form-control'><span class='font-awesome'>&#xf1f8;</span>&nbsp;Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                    ROLE;
                                }
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>