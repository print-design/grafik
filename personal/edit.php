<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        include '../include/restrict_logged_in.php';
        
        // Получение личных данных
        $name = '';
        $username = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select name, username 
            from user where id=".GetUserId();
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $name = $row['name'];
            $username = $row['username'];
        }
        $conn->close();
        
        // Валидация формы
        define('ISINVALID', ' is-invalid');
        $form_valid = true;
        $error_message = '';
        
        $name_valid = '';
        $username_valid = '';
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_edit_submit'])) {
            if($_POST['name'] == '') {
                $name_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($_POST['username'] == '') {
                $username_valid = ISINVALID;
                $form_valid = false;
            }
                        
            if($form_valid) {
                $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                if($conn->connect_error) {
                    die('Ошибка соединения: '.$conn->connect_error);
                }
                
                $name = addslashes($_POST['name']);
                $username = addslashes($_POST['username']);
                
                $sql = "update user set name='$name', username='$username' where id=".GetUserId();
                
                if ($conn->query($sql) === true) {
                    header('Location: '.APPLICATION.'/personal/');
                }
                else {
                    $error_message = $conn->error;
                }
                
                $conn->close();
            }
        }
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
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="d-flex justify-content-between">
                        <div class="p-1">
                            <h1>Редактирование личных данных</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/personal/" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <hr/>
                    <form method="post">
                        <div class="form-group">
                            <label for="name">ФИО</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) ? $_POST['name'] : $name ?>" autocomplete="off" required="required"/>
                            <div class="invalid-feedback">ФИО обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="username">Логин</label>
                            <input type="text" id="username" name="username" class="form-control<?=$username_valid ?>" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) ? htmlentities($_POST['username']) : $username ?>" autocomplete="off" required="required"/>
                            <div class="invalid-feedback">Логин обязательно</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-dark" id="user_edit_submit" name="user_edit_submit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>