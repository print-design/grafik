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
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_edition_submit'])) {
            if($_POST['name'] == '') {
                $name_valid = ISINVALID;
                $form_valid = false;
            }
            
            if($form_valid) {
                $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                if($conn->connect_error) {
                    die('Ошибка соединения: '.$conn->connect_error);
                }
                
                $name = addslashes($_POST['name']);
                $organization_id = $_POST['organization_id'];
                
                $sql = "insert into edition (name, organization_id) values ('$name', $organization_id)";
                
                if ($conn->query($sql) === true) {
                    header('Location: '.APPLICATION.'/organization/details.php?id='.$organization_id);
                }
                else {
                    $error_message = $conn->error;
                }
                
                $conn->close();
            }
        }
        
        // Если нет параметра id, переход к списку
        if(!isset($_GET['id'])) {
            header('Location: '.APPLICATION.'/organization/');
        }
        
        // Получение объекта
        $name = '';
        
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        $sql = "select name from organization where id=".$_GET['id'];
        
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
                                <a href="<?=APPLICATION ?>/organization/" class="btn btn-outline-dark"><span class="font-awesome">&#xf0e2;</span>&nbsp;К списку</a>
                                <a href="<?=APPLICATION ?>/organization/edit.php?id=<?=$_GET['id'] ?>" class="btn btn-outline-dark"><span class="font-awesome">&#xf044;</span>&nbsp;Редактировать</a>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="p-1">
                            <h2>Тиражи</h2>
                        </div>
                        <div class="p-1">
                            <form class="form-inline" method="post">
                                <div class="input-group">
                                    <input type="hidden" id="organization_id" name="organization_id" value="<?=$_GET['id'] ?>"/>
                                    <input type="name" class="form-control<?=$name_valid ?>" placeholder="Наименование тиража" id="name" name="name" required="required" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-dark" id="add_edition_submit" name="add_edition_submit">
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
                            $edition_name = '';
                            
                            $edition_conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                            $edition_sql = "select id, name from edition where organization_id=".$_GET['id'];
                            
                            if($edition_conn->connect_error) {
                                die('Ошибка соединения: ' . $edition_conn->connect_error);
                            }
                            
                            $edition_result = $edition_conn->query($edition_sql);
                            if ($edition_result->num_rows > 0) {
                                while($edition_row = $edition_result->fetch_assoc()) {
                                    echo "<tr>"
                                            ."<td>".htmlentities($edition_row['name'])."</td>"
                                            ."<td><a title='Редактировать' href='edit_edition.php?id=".$edition_row['id']."'><span class='font-awesome'>&#xf044;</span></a></td>"
                                            ."</tr>";
                                }
                            }
                            $edition_conn->close();
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