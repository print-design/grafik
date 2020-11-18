<!DOCTYPE html>
<html>
    <head>
        <?php
        include '../include/head.php';
        include '../include/restrict_admin.php';
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
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1">
                    <h1>Пользователи</h1>
                </div>
                <div class="p-1">
                    <a href="create.php" title="Добавить пользователя" class="btn btn-outline-dark mr-sm-2">
                        <span class="font-awesome">&#xf067;</span>&nbsp;Добавить
                    </a>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Зарегистрирован</th>
                        <th>Логин</th>
                        <th>ФИО</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Роли</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                    $sql = "select u.id, date_format(u.date, '%d.%m.%Y') date, u.username, u.name, u.first_name, u.middle_name, "
                            . "(SELECT GROUP_CONCAT(DISTINCT r.local_name SEPARATOR ', ') FROM role r inner join user_role ur on ur.role_id = r.id where ur.user_id = u.id) roles "
                            . "from user u order by u.name asc";
                            
                    if($conn->connect_error) {
                        die('Ошибка соединения: ' . $conn->connect_error);
                    }
                    
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>"
                                    ."<td>".$row['date']."</td>"
                                    ."<td><a href='".APPLICATION."/user/details.php?id=".$row['id']."'>".$row['username']."</a></td>"
                                    ."<td>".$row['name']."</td>"
                                    ."<td>".$row['first_name']."</td>"
                                    ."<td>".$row['middle_name']."</td>"
                                    ."<td>".$row['roles']."</td>"
                                    ."</tr>";
                        }
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>