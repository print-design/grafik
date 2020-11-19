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
                
                $id = $_POST['id'];
                $name = addslashes($_POST['name']);
                $username = addslashes($_POST['username']);
                
                $sql = "update user set name='$name', username='$username' where id=$id";
                
                if ($conn->query($sql) === true) {
                    header('Location: '.APPLICATION.'/user/details.php?id='.$id);
                }
                else {
                    $error_message = $conn->error;
                }
                
                $conn->close();
            }
        }
        
        // Если нет параметра id, переход к списку
        if(!isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/user/');
        }
        
        // Получение объекта
        $name = '';
        $username = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select name, username from user where id=".$_GET['id'];
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $name = $row['name'];
            $username = $row['username'];
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
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1>Редактирование пользователя</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/user/details.php?id=<?=$_GET['id'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <hr/>
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>"/>
                        <div class="form-group">
                            <label for="name">ФИО</label>
                            <input type="text" id="name" name="name" class="form-control<?=$name_valid ?>" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) ? htmlentities($_POST['name']) : htmlentities($name) ?>" autocomplete="off" required="required"/>
                            <div class="invalid-feedback">ФИО обязательно</div>
                        </div>
                        <div class="form-group">
                            <label for="username">Логин</label>
                            <input type="text" id="username" name="username" class="form-control<?=$username_valid ?>" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) ? htmlentities($_POST['username']) : htmlentities($username) ?>" autocomplete="off" required="required"/>
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