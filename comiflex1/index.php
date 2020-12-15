<?php
include '../include/topscripts.php';
include '../include/grafik.php';
include '../include/date_from_date_to.php';

$grafik = new Grafik($date_from, $date_to, 1);
$grafik->user1Name = 'Печатник';
$grafik->user2Name = 'Помощник';
$grafik->sqlUser1 = 'select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 3 order by u.fio';
$grafik->sqlUser2 = 'select u.id, u.fio from user u inner join user_role ur on ur.user_id = u.id where ur.role_id = 3 order by u.fio';

$grafik->hasEdition = true;
$grafik->hasOrganization = true;
$grafik->hasLength = true;
$grafik->hasRoller = true;
$grafik->hasLamination = true;
$grafik->hasColoring = true;
$grafik->hasManager = true;

$grafik->ProcessForms();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>График - Comiflex</title>
        <?php
        include '../include/head.php';
        ?>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>
        <div class="container-fluid">
            <?php
            if(isset($error_message) && $error_message != '') {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            $grafik->ShowPage();
            ?>
        </div>
        <?php
            include '../include/footer.php';
        ?>
        <script>
            $('select[id=user1_id],select[id=user2_id],select[id=manager_id]').change(function(){
                if(this.value == '+') {
                    $(this).parent().next().removeClass('d-none');
                    $(this).parent().addClass('d-none');
                    return;
                }
                this.form.submit();
            });
        </script>
    </body>
</html>