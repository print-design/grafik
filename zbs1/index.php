<?php
include '../include/topscripts.php';
include '../include/grafik.php';
include '../include/date_from_date_to.php';

$grafik = new Grafik($date_from, $date_to, 2);
$grafik->name = 'ZBS-1';
$grafik->user1Name = "Печатник";
$grafik->userRole = 6;

$grafik->hasEdition = true;
$grafik->hasOrganization = true;
$grafik->hasLength = true;
$grafik->hasRoller = true;
$grafik->hasLamination = true;
$grafik->hasColoring = true;
$grafik->coloring = 6;
$grafik->hasManager = true;

$grafik->ProcessForms();
$error_message = $grafik->error_message;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>График - ZBS-1</title>
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