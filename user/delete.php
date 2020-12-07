<?php
include '../include/topscripts.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        include '../include/restrict_admin.php';
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_submit'])) {
            $user_id = $_POST['id'];
            $user_role_sql = "delete from user_role where user_id=$user_id";
            $error_message = ExecuteSql($user_role_sql);
            
            if($error_message == '') {
                $user_sql = "delete from user where id=$user_id";
                $error_message = ExecuteSql($user_sql);
                
                if($error_message == '') {
                    header('Location: '.APPLICATION.'/user/');
                }
            }
        }
        
        // Если нет параметра id, переход к списку
        if(!isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/user/');
        }
        
        // Получение объекта
        $id = $_GET['id'];
        $username = '';
        $fio = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select username, fio from user where id=$id";
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        
        mysqli_query($conn, 'set names utf8');
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $username = $row['username'];
            $fio = $row['fio'];
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
                <div class="col-12 col-md-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h1 class="text-danger">Дествительно удалить?</h1>
                        </div>
                        <div class="p-1">
                            <a href="<?=APPLICATION ?>/user/details.php?id=<?=$id ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;Отмена</a>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Логин</th>
                            <td><?=$username ?></td>
                        </tr>
                        <tr>
                            <th>ФИО</th>
                            <td><?=$fio ?></td>
                        </tr>
                    </table>
                    <form method="post">
                        <input type="hidden" id="id" name="id" value="<?=$id ?>"/>
                        <button type="submit" id="delete_user_submit" name="delete_user_submit" class="btn btn-outline-dark">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>