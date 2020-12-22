<div class="container-fluid">
    <nav class="navbar navbar-expand-sm">
        <a class="navbar-brand" href="<?=APPLICATION ?>/">
            <i class="fas fa-home"></i>
        </a>
        <ul class="navbar-nav mr-auto">
            <?php
            $comiflex_status = $_SERVER['PHP_SELF'] == APPLICATION.'/comiflex/index.php' ? ' disabled' : '';
            $zbs1_status = $_SERVER['PHP_SELF'] == APPLICATION.'/zbs1/index.php' ? ' disabled' : '';
            $zbs2_status = $_SERVER['PHP_SELF'] == APPLICATION.'/zbs2/index.php' ? ' disabled' : '';
            $zbs3_status = $_SERVER['PHP_SELF'] == APPLICATION.'/zbs3/index.php' ? ' disabled' : '';
            $atlas_status = $_SERVER['PHP_SELF'] == APPLICATION.'/atlas/index.php' ? ' disabled' : '';
            $laminators_status = $_SERVER['PHP_SELF'] == APPLICATION.'/laminators/index.php' ? ' disabled' : '';
            $cutters_status = $_SERVER['PHP_SELF'] == APPLICATION.'/cutters/index.php' ? ' disabled' : '';
            $machine_status = $_SERVER['PHP_SELF'] == APPLICATION.'/machine/index.php' ? ' disabled' : '';
            $lamination_status = $_SERVER['PHP_SELF'] == APPLICATION.'/lamination/index.php' ? ' disabled' : '';
            $user_status = $_SERVER['PHP_SELF'] == APPLICATION.'/user/index.php' ? ' disabled' : '';
            $personal_status = $_SERVER['PHP_SELF'] == APPLICATION.'/personal/index.php' ? ' disabled' : '';
            
            $query_string = '';
            $period = array();
            if(isset($_GET['from']) && $_GET['from'] != '')
                $period['from'] = $_GET['from'];
            if(isset($_GET['to']) && $_GET['to'] != '')
                $period['to'] = $_GET['to'];
            if(count($period) > 0)
                $query_string = '?'.http_build_query ($period);
            ?>
            <li class="nav-item">
                <a class="nav-link<?=$comiflex_status ?>" href="<?=APPLICATION ?>/comiflex/<?=$query_string ?>">Comiflex</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$zbs1_status ?>" href="<?=APPLICATION ?>/zbs1/<?=$query_string ?>">ZBS-1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$zbs2_status ?>" href="<?=APPLICATION ?>/zbs2/<?=$query_string ?>">ZBS-2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$zbs3_status ?>" href="<?=APPLICATION ?>/zbs3/<?=$query_string ?>">ZBS-3</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$atlas_status ?>" href="<?=APPLICATION ?>/atlas/<?=$query_string ?>">Атлас</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$laminators_status ?>" href="<?=APPLICATION ?>/laminators/<?=$query_string ?>">Ламинатор</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?=$cutters_status ?>" href="<?=APPLICATION ?>/cutters/<?=$query_string ?>">Резка</a>
            </li>
            <?php
            if(LoggedIn()) {
            ?>
            <li class="nav-item">
                <a class="nav-link<?=$personal_status ?>" href="<?=APPLICATION ?>/personal/">Мои настройки</a>
            </li>
            <?php
            }
            if(IsInRole('admin')) {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    Администратор
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item<?=$user_status ?>" href="<?=APPLICATION ?>/user/">Пользователи</a>
                    <a class="dropdown-item<?=$machine_status ?>" href="<?=APPLICATION ?>/machine/">Машины</a>
                </div>
            </li>
            <?php
            }
            ?>
        </ul>
        <?php
        if(isset($_COOKIE[USERNAME]) && $_COOKIE[USERNAME] != '') {
        ?>
        <form class="form-inline" method="post">
            <label>
                <?php
                $full_user_name = '';
                if(isset($_COOKIE[FIO]) && $_COOKIE[FIO] != '') {
                    $full_user_name .= $_COOKIE[FIO];
                }
                echo $full_user_name;
                ?>
                &nbsp;
            </label>
            <button type="submit" class="btn btn-outline-dark" id="logout_submit" name="logout_submit">Выход&nbsp;<i class="fas fa-sign-out-alt"></i></button>
        </form>
        <?php
        }
        else {
        ?>
        <form class="form-inline my-2 my-lg-0" method="post">
            <div class="form-group">
                <input class="form-control mr-sm-2<?=$login_username_valid ?>" type="text" id="login_username" name="login_username" placeholder="Логин" value="<?=$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_username']) ? $_POST['login_username'] : '' ?>" required="required" autocomplete="on" />
                <div class="invalid-feedback">*</div>
            </div>
            <div class="form-group">
                <input class="form-control mr-sm-2<?=$login_password_valid ?>" type="password" id="login_password" name="login_password" placeholder="Пароль" required="required" />
                <div class="invalid-feedback">*</div>
            </div>
            <button type="submit" class="btn btn-outline-dark my-2 my-sm-2" id="login_submit" name="login_submit">Войти&nbsp;<i class="fas fa-sign-in-alt"></i></button>
        </form>
        <?php
        }
        ?>
    </nav>
</div>
<hr />