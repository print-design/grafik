<?php
include '../include/topscripts.php';
include '../include/restrict_logged_in.php';
include '../include/grafik.php';

$date_from = null;
$date_to = null;
GetDateFromDateTo(filter_input(INPUT_GET, 'from'), filter_input(INPUT_GET, 'to'), $date_from, $date_to);

$grafik = new Grafik($date_from, $date_to, 11);
$grafik->name = 'Резка &laquo;Атлас&raquo;';
$grafik->user1Name = 'Резчик';
$grafik->userRole = 5;

$grafik->hasEdition = true;
$grafik->hasOrganization = true;
$grafik->hasLength = true;
$grafik->hasManager = true;
$grafik->hasComment = true;
$grafik->isCutter = true;

$grafik->ProcessForms();
$error_message = $grafik->error_message;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>График - Резка "Атлас"</title>
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
    </body>
</html>