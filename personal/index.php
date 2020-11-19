<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        include '../include/restrict_logged_in.php';
        
        // Получение личных данных
        $fio = '';
        $username = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select fio, username from user where id=".GetUserId();
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $fio = $row['fio'];
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
            <?php
            if(isset($error_message) && $error_message != '') {
               echo <<<ERROR
               <div class="alert alert-danger">$error_message</div>
               ERROR;
            }
               
            if(isset($_GET['password']) && $_GET['password'] == 'true') {
                echo <<<PASSWORD
                <div class="alert alert-info">Пароль успешно изменён</div>
                PASSWORD;
            }
            ?>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between">
                        <div class="p-1">
                            <h1>Мои настройки</h1>
                        </div>
                        <div class="p-1">
                            <div class="btn-group">
                                <a href="<?=APPLICATION ?>/personal/edit.php" class="btn btn-outline-dark"><span class="font-awesome">&#xf044;</span>&nbsp;Редактировать</a>
                                <a href="<?=APPLICATION ?>/personal/password.php" class="btn btn-outline-dark"><span class="font-awesome">&#xf023;</span>&nbsp;Сменить пароль</a>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <table class="table table-bordered">
                        <tr>
                            <th>ФИО</th>
                            <td><?=$fio ?></td>
                        </tr>
                        <tr>
                            <th>Логин</th>
                            <td><?=$username ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>