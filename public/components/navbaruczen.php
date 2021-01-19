<?php 
    session_start(); 
    $current_script = basename($_SERVER["SCRIPT_FILENAME"], '.php'); 
?>
<header style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
    <nav class="top-nav teal">
        <div class="nav-wrapper">
            <a href="#" data-target="nav-mobile" class="top-nav" style="display: block; height: 64px; line-height: 64px; float: left; position: relative; z-index: 1; margin-left: 18px; margin-right: 18px;" onclick="toggleSidebar();">
                <i class="material-icons">menu</i>
            </a>
            <p style="font-size: x-large; margin: auto; /*margin-left: 18px;*/">Dziennik internetowy</a>
        </div>
    </nav>
    <ul class="sidenav sidenav-fixed" style="transform: none; transition: transform 225ms cubic-bezier(0, 0, 0.2, 1) 0ms;">
        <li>
            <div class="user-view">
                <h6 class="text"><b>Zalogowany jako:</b></h6>
                <h6 class="text"><?= $_SESSION["user"]["imie"] ?> <?= $_SESSION["user"]["nazwisko"] ?> (uczeń)</h6>
                <div class="section" style="padding-top: 0;">
                    <a href="wyloguj.php" class="btn-flat teal-text waves-effect" style="padding: 0;">Wyloguj się</a>
                </div>
            </div>
        </li>
        <li><div class="divider"></div></li>
        <li <?php if($current_script == "ocenyuczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="ocenyuczen.php">Oceny</a></li>
        <li <?php if($current_script == "nieobecnosciuczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="nieobecnosciuczen.php">Nieobecności</a></li>
        <li <?php if($current_script == "uwagiuczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="uwagiuczen.php">Uwagi</a></li>
        <li <?php if($current_script == "sprawdzianyuczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="sprawdzianyuczen.php">Sprawdziany</a></li>
        <li <?php if($current_script == "pracadomowauczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="pracadomowauczen.php">Prace domowe</a></li>
        <li <?php if($current_script == "zastepstwauczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="zastepstwauczen.php">Zastępstwa</a></li>
        <li <?php if($current_script == "planlekcjiuczen") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="planlekcjiuczen.php">Plan lekcji</a></li>
    </ul>
</header>

<script>
    let instances;

    document.addEventListener('DOMContentLoaded', function() {
        let header = document.querySelectorAll('header')[0];
        let main = document.querySelectorAll('main')[0];
        let elems = document.querySelectorAll('.sidenav');
        instances = M.Sidenav.init(elems, {
            onOpenStart: () => {
                header.style.marginLeft = "300px"
                main.style.marginLeft = '300px'
            },
            onCloseStart: () => {
                header.style.marginLeft = "0px"
                main.style.marginLeft = "0px"
            }
        });
    });

    function toggleSidebar()
    {
        if(instances[0].isOpen)
            instances[0].close();
        else 
            instances[0].open();
    }
</script>