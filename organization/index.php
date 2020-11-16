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
        include '../include/pager_top.php';
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
                            <h1>Предприятия</h1>
                        </div>
                        <div class="p-1">
                            <form class="form-inline" method="get">
                                <a href="create.php" title="Добавить предприятие" class="btn btn-outline-dark mr-sm-2">
                                    <span class="font-awesome">&#xf067;</span>&nbsp;Добавить
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Поиск" id="find" name="find" value="<?= isset($_GET['find']) ? $_GET['find'] : '' ?>" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-outline-dark"><span class="font-awesome">&#xf002;</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Добавлено</th>
                                <th>Наименование</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
                            
                            if($conn->connect_error) {
                                die('Ошибка соединения: ' . $conn->connect_error);
                            }
                            
                            $find = '';
                            if(isset($_GET['find'])){
                                $find = " where name like '%".$_GET['find']."%' ";
                            }
                            
                            $sql = "select count(id) count from organization".$find;
                            
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                if($row = $result->fetch_assoc()) {
                                    $pager_total_count = $row['count'];
                                }
                            }
                            
                            $sql = "select id, date_format(date, '%d.%m.%Y') date, name from organization "
                                    . $find
                                    . " order by name asc";
                            
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>"
                                            ."<td>".$row['date']."</td>"
                                            ."<td><a href='details.php?id=".$row['id']."'>".$row['name']."</a></td>"
                                            ."</tr>";
                                }
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <?php
                    include '../include/pager_bottom.php';
                    ?>
                </div>
            </div>
        </div>
        <?php
        include '../include/footer.php';
        ?>
    </body>
</html>