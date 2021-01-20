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
                <h6 class="text"><?= $_SESSION["user"]["imie"] ?> <?= $_SESSION["user"]["nazwisko"] ?> (nauczyciel)</h6>
                <div class="section" style="padding-top: 0;">
                    <a href="wyloguj.php" class="btn-flat teal-text waves-effect" style="padding: 0;">Wyloguj się</a>
                </div>
            </div>
        </li>
        <li><div class="divider"></div></li>
        <li <?php if($current_script == "oceny") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="oceny.php">Oceny</a></li>
        <li <?php if($current_script == "nieobecnosci") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="nieobecnosci.php">Nieobecności</a></li>
        <li <?php if($current_script == "uwagi") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="uwagi.php">Uwagi</a></li>
        <li <?php if($current_script == "sprawdziany") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="sprawdziany.php">Sprawdziany</a></li>
        <li <?php if($current_script == "pracadomowa") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="pracadomowa.php">Prace domowe</a></li>
        <li <?php if($current_script == "zastepstwa") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="zastepstwa.php">Zastępstwa</a></li>
        <li <?php if($current_script == "planlekcji") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="planlekcji.php">Plan lekcji</a></li>
        <div class="divider"></div>
        <li <?php if($current_script == "konta") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="konta.php">Konta</a></li>
        <li <?php if($current_script == "klasy") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="klasy.php">Klasy</a></li>
        <li <?php if($current_script == "przedmioty") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="przedmioty.php">Przedmioty</a></li>
        <li <?php if($current_script == "przydzialprzedmiotow") echo 'class="active"' ?>><a class="waves-effect waves-teal" href="przydzialprzedmiotow.php">Przydział przedmiotów</a></li>
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