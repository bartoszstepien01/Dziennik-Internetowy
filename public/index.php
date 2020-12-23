<?php 
    require("config.php");

    $grades = $database->query("SELECT * FROM klasy;");
    $subjects = $database->query("SELECT * FROM przedmioty;");
?>

<!DOCTYPE html>
<html lang="pl" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Dziennik internetowy</title>
</head>
<body class="grey lighten-4" style="height: 100%;">
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
                    <h6 class="text">Jan Kowalski (nauczyciel)</h6>
                    <div class="section" style="padding-top: 0;">
                        <a class="btn-flat teal-text waves-effect" style="padding: 0;">Dane konta</a>
                        <a class="btn-flat teal-text waves-effect">Wyloguj się</a>
                    </div>
                </div>
                
            </li>
            <li><div class="divider"></div></li>
            <li class="active"><a class="waves-effect waves-teal" href="#!">Wstawianie ocen</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Sprawdzanie obecności</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Wstawianie uwag</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Dodawanie sprawdzianów</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Dodawanie prac domowych</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Dodawanie zastępstw</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Korespondencja</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Edycja planu lekcji</a></li>
            <li><div class="divider"></div></li>
            <li><a class="waves-effect waves-teal" href="#!">Wyświetlanie ocen</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Wyświetlanie nieobecności</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Wyświetlanie uwag</a></li>
            <li><a class="waves-effect waves-teal" href="#!">Podgląd kalendarza</a></li>
        </ul>
    </header>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Wstawianie ocen</h3>
            <div class="card" style="padding: 1rem;">  
                <form action="wystawoceny.php" method="post">
                    <div class="input-field">
                        <select multiple name="grade[]">
                            <?php while($row = $grades->fetch_assoc()): ?>
                                <option value="<?= $row["idklasy"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Klasa</label>
                    </div>
                    <div class="input-field">
                        <select multiple name="subject[]">
                            <?php while($row = $subjects->fetch_assoc()): ?>
                                <option value="<?= $row["idprzedmioty"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Przedmiot</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        let instances;

        let header = document.querySelectorAll('header')[0];
        let main = document.querySelectorAll('main')[0];

        document.addEventListener('DOMContentLoaded', function() {
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
            elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });

        function toggleSidebar()
        {
            if(instances[0].isOpen)
                instances[0].close();
            else 
                instances[0].open();
        }
    </script>
</body>
</html>