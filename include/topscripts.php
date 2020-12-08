<?php
include 'define.php';

$weekdays = array();
$weekdays[0] = 'Вс';
$weekdays[1] = 'Пн';
$weekdays[2] = 'Вт';
$weekdays[3] = 'Ср';
$weekdays[4] = 'Чт';
$weekdays[5] = 'Пт';
$weekdays[6] = 'Сб';

// Функции
function LoggedIn() {
    if(isset($_COOKIE[USERNAME]) && $_COOKIE[USERNAME] != '') {
        return true;
    }
    else {
        return false;   
    }
}

function GetUserId() {
    return $_COOKIE[USER_ID];
}

function IsInRole($role) {
    if(isset($_COOKIE[ROLES])) {
        $roles = unserialize($_COOKIE[ROLES]);
        if(in_array($role, $roles))
                return true;
    }
    
    return false;
}

function AddHiddenFields($dateshift, $row) {
    echo '<input type="hidden" id="scroll" name="scroll" />';
    if(isset($row['id'])) {
        echo '<input type="hidden" id="id" name="id" value="'.$row['id'].'" />';
    }
    echo '<input type="hidden" id="date" name="date" value="'.$dateshift['date']->format('Y-m-d').'" />';
    echo '<input type="hidden" id="shift" name="shift" value="'.$dateshift['shift'].'" />';
    if(isset($_GET['from'])) {
        echo '<input type="hidden" id="from" name="from" value="'.$_GET['from'].'" />';
    }
    if(isset($_GET['to'])) {
        echo '<input type="hidden" id="to" name="to" value="'.$_GET['to'].'" />';
    }
}

// Классы
class Executer {
    public $error = '';
    
    function __construct($sql) {
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

        if($conn->connect_error) {
            $this->error = 'Ошибка соединения: '.$conn->connect_error;
            return;
        }
        
        $conn->query('set names utf8');
        $result = $conn->query($sql);
        $this->error = $conn->error;
        
        $conn->close();
    }
}

class Grabber {
    public  $error = '';
    public $result = array();
            
    function __construct($sql) {
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        
        if($conn->connect_error) {
            $this->error = 'Ошибка соединения: '.$conn->connect_error;
            return;
        }
        
        $conn->query('set names utf8');
        $result = $conn->query($sql);
        
        if(is_bool($result)) {
            $this->error = $conn->error;
        }
        else {
            $this->result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        
        $conn->close();
    }
}

class Fetcher {
    public $error = '';
    private $result;
            
    function __construct($sql) {
        $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        
        if($conn->connect_error) {
            $this->error = 'Ошибка соединения: '.$conn->connect_error;
            return;
        }
        
        $conn->query('set names utf8');
        $this->result = $conn->query($sql);
        
        if(is_bool($this->result)) {
            $this->error = $conn->error;
        }
        
        $conn->close();
    }
    
    function Fetch() {
        return mysqli_fetch_array($this->result);
    }
}

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