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
        
        // Обработка отправки формы
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_roller_submit'])) {
            if($_POST['name'] == '') {
                $name_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($form_valid) {
                $name = addslashes($_POST['name']);
                $machine_id = $_POST['machine_id'];
                $sql = "insert into roller (name, machine_id) values ('$name', $machine_id)";
                $error_message = ExecuteSql($sql);
                
                if($error_message == '') {
                    header('Location: '.APPLICATION.'/machine/details.php?id='.$machine_id);
                }
            }
        }
        
        // Если нет параметра id, переход к списку
        if(!isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/machine/');
        }
        
        // Получение объекта
        $name = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select name from machine where id=".$_GET['id'];
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $name = htmlentities($row['name']);
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
                            <h1><?=$name ?></h1>
                        </div>
                        <div class="p-1">
                            <div class="btn-group">
                                <a href="<?=APPLICATION ?>/machine/" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;К списку</a>
                                <a href="<?=APPLICATION ?>/machine/edit.php?id=<?=$_GET['id'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf044;</span>&nbsp;Редактировать</a>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h2>Валы</h2>
                        </div>
                        <div class="p-1">
                            <form class="form-inline" method="post">
                                <div class="input-group">
                                    <input type="hidden" id="machine_id" name="machine_id" value="<?=$_GET['id'] ?>"/>
                                    <input type="name" class="form-control<?=$name_valid ?>" placeholder="Наименование вала" id="name" name="name" required="required" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-dark" id="add_roller_submit" name="add_roller_submit">
                                            <span class="font-awesome">&#xf067;</span>&nbsp;Добавить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <?php
                            $roller_name = '';
                            
                            $roller_conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                            $roller_sql = "select id, name from roller where machine_id=".$_GET['id'];
                            
                            if($roller_conn->connect_error) {
                                die('Ошибка соединения: ' . $roller_conn->connect_error);
                            }
                            
                            $roller_result = $roller_conn->query($roller_sql);
                            if ($roller_result->num_rows > 0) {
                                while($roller_row = $roller_result->fetch_assoc()) {
                                    echo "<tr>"
                                            ."<td>".htmlentities($roller_row['name'])."</td>"
                                            ."<td><a title='Редактировать' href='edit_roller.php?id=".$roller_row['id']."'><span class='font-awesome'>&#xf044;</span></a></td>"
                                            ."</tr>";
                                }
                            }
                            $roller_conn->close();
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