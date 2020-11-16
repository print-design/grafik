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
                $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                if($conn->connect_error) {
                    die('Ошибка соединения: '.$conn->connect_error);
                }
                
                $user_id = $_POST['user_id'];
                $role_id = $_POST['role_id'];
                
                $sql = "insert into user_role (user_id, role_id) values ($user_id, $role_id)";
                
                if ($conn->query($sql) === true) {
                    header('Location: '.APPLICATION.'/user/details.php?id='.$user_id);
                }
                else {
                    $error_message = $conn->error;
                }
                
                $conn->close();
            }
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_role_submit'])) {
            $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
            if($conn->connect_error) {
                die('Ошибка соединения: '.$conn->connect_error);
            }
            
            $user_id = $_POST['user_id'];
            $role_id = $_POST['role_id'];
            $sql = "delete from user_role where user_id = $user_id and role_id = $role_id";
            
            if ($conn->query($sql) === true) {
                header('Location: '.APPLICATION.'/user/details.php?id='.$user_id);
            }
            else {
                $error_message = $conn->error;
            }
            
            $conn->close();
        }
        
        // Если нет параметра id, переход к списку
        if(!isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/user/');
        }
        
        // Получение объекта
        $username = '';
        $last_name = '';
        $first_name = '';
        $middle_name = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select username, last_name, first_name, middle_name from user where id = ".$_GET['id'];
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $username = $row['username'];
            $last_name = $row['last_name'];
            $first_name = $row['first_name'];
            $middle_name = $row['middle_name'];
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
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Фамилия</th>
                            <td><?=$last_name ?></td>
                        </tr>
                        <tr>
                            <th>Имя</th>
                            <td><?=$first_name ?></td>
                        </tr>
                        <tr>
                            <th>Отчество</th>
                            <td><?=$middle_name ?></td>
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