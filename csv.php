<?php
include 'include/topscripts.php';
include 'include/grafik.php';

$export_submit = filter_input(INPUT_POST, 'export_submit');
if($export_submit !== null) {
    $titles = array("id", "date", "shift", "user1_id", "user1", "user2_id", "user2", "machine_id");
    $data = array(
	array(1, 'Имя 1'),
	array(2, 'Имя 2'),
	array(3, 'Имя 3'),
	array(4, 'Имя 4'),
	array(5, 'Имя 5'),
	array(5, 'Имя 6 с кавычкой " или \' '),
    );
    
    $from = filter_input(INPUT_POST, 'from');
    $to = filter_input(INPUT_POST, 'to');
    $file_name = "grafik-ot-$from-do-$to.csv";
    
    DownloadSendHeaders($file_name);
    echo Array2Csv($data, $titles);
    die();
}
?>
<html>
    <body>
        <h1>Чтобы экспортировать в CSV надо наэати на кнопку "Экспорт" в верхней правой части страницы.</h1>
    </body>
</html>