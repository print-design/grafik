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
        
        $fio_valid = '';
        $username_valid = '';
        $password_valid = '';
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_create_submit'])) {
            if($_POST['fio'] == '') {
                $fio_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($_POST['username'] == '') {
                $username_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($_POST['password'] == '') {
                $password_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($form_valid) {
                $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                if($conn->connect_error) {
                    die('Ошибка соединения: '.$conn->connect_error);
                }
                
                $fio = addslashes($_POST['fio']);
                $username = addslashes($_POST['username']);
                $password = addslashes($_POST['password']);
                
                $sql = "insert into user (fio, username, password) values ('$fio', '$username', password('$password'))";
                
                if ($conn->query($sql) === true) {
                    header('Location: '.APPLICATION.'/user/');
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
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>Новый пользователь</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/user/" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <hr/>
                    <form method="post">
                        <div class="form-group">
                            <label for="name">ФИО</label>
                            <input type="text" id="fio" name="fio" class="form-control<?=$fio_valid ?>" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fio']) ? $_POST['fio'] : '' ?>" autocomplete="off" required="required"/>
                            <div class="invalid-feedback">ФИО обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="username">Логин</label>
                            <input type="text" id="username" name="username" class="form-control<?=$username_valid ?>" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) ? $_POST['username'] : '' ?>" required="required" autocomplete="off"/>
                            <div class="invalid-feedback">Логин обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control<?=$password_valid ?>" required="required" autocomplete="off"/>
                            <div class="invalid-feedback">Пароль обязательно</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-dark" id="user_create_submit" name="user_create_submit">Сохранить</button>
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