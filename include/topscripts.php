<?php
define('APPLICATION', '/grafik');

define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME', 'grafik');

define('USER_ID', '543fde_fgeeferlj76_huGTF_eerrFE_er_eeWE');
define('USERNAME', 'jjjgYY7765_kjnbhg77GGH_ijjhg__weeewZX');
define('FIO', 'dff_juHHYG_njhq_lkoyGF_yetGBVk_iju_ssh');
define('ROLES', 'ffe__jjHHHYff_kijUH_uytw_plOKqwvgGGFsd_kiJS');

define('SCROLL', 'rieu_3376gJHyt_uurygYY65ki_876gyGGTj_okki');

// Валидация формы логина
define('LOGINISINVALID', ' is-invalid');
$login_form_valid = true;

$login_username_valid = '';
$login_password_valid = '';

// Обработка отправки формы логина
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_submit'])){
    if($_POST['login_username'] == '') {
        $login_username_valid = LOGINISINVALID;
        $login_form_valid = false;
    }
    
    if($_POST['login_password'] == '') {
        $login_password_valid = LOGINISINVALID;
        $login_form_valid = false;
    }
    
    if($login_form_valid) {
        $login_user_id = '';
        $login_username = '';
        $login_fio = '';
        $login_roles = '';

        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        mysqli_query($conn, 'set names utf8');
        $sql = "select id, username, fio from user where username='".$_POST['login_username']."' and password=password('".$_POST['login_password']."')";
        
        if($conn->connect_error) {
            die('Ошибка соединения: ' . $conn->connect_error);
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $login_user_id = $row['id'];
            setcookie(USER_ID, $row['id'], 0, "/");
            
            $login_username = $row['username'];
            setcookie(USERNAME, $row['username'], 0, "/");
            
            $login_fio = $row['fio'];
            setcookie(FIO, $row['fio'], 0, "/");
        }
        else {
            $error_message = "Неправильный логин или пароль.";
        }
        
        if($login_user_id != '') {
            $role_sql = "select r.name from user_role ur inner join role r on ur.role_id = r.id where ur.user_id = ".$login_user_id;
            $role_result = $conn->query($role_sql);
            if($role_result->num_rows > 0) {
                $roles = array();
                $role_i = 0;
                while ($role_row = $role_result->fetch_assoc()) {
                    $roles[$role_i++] = $role_row['name'];
                }
                
                setcookie(ROLES, serialize($roles), 0, '/');
            }
        }
        
        $conn->close();
        
        if($login_username != '') {
            header("Refresh:0");
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout_submit'])) {
    setcookie(USER_ID, '', 0, "/");
    setcookie(USERNAME, '', 0, "/");
    setcookie(FIO, '', 0, "/");
    setcookie(ROLES, '', 0, "/");
    header("Refresh:0");
    header('Location: '.APPLICATION.'/');
}
?>