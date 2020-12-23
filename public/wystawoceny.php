<?php 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
        $grades = implode(", ", $_POST["grade"]);
        $subjects = implode(", ", $_POST["subject"]);

        $grades = $database->query("SELECT * FROM klasy WHERE idklasy IN ($grades) ORDER BY idklasy;");
        $subjects = $database->query("SELECT * FROM przedmioty WHERE idprzedmioty IN ($subjects) ORDER BY idprzedmioty;");
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
    <style>
        table {
            table-layout: fixed;
        }

        input {
            margin: 0 !important;
        }

        td {
            padding-top: 7.5px;
            padding-bottom: 7.5px;
        }
    </style>
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
                <form action="wystawoceny2.php" method="post">
                    <?php while($row1 = $subjects->fetch_assoc()): ?>
                        <h4><?= $row1["nazwa"] ?></h4>
                        <?php while($row = $grades->fetch_assoc()): ?>
                            <h6>Klasa <?= $row["nazwa"] ?></h6>
                            <table class="striped">
                                <thead>
                                    <tr>
                                        <th>Lp.</th>
                                        <th>Imię i nazwisko</th>
                                        <th>Oceny</th>
                                        <th>Ocena wstawiana</th>
                                        <th>Opis oceny</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $grade = $row["idklasy"];
                                        $subject = $row1["idprzedmioty"];
                                        $students = $database->query("SELECT 
                                                uczniowie.iduczniowie, 
                                                uczniowie.nazwisko, 
                                                uczniowie.imie, 
                                                GROUP_CONCAT(oceny.ocena ORDER BY oceny.idoceny SEPARATOR ', ') AS oceny 
                                            FROM uczniowie 
                                            LEFT JOIN oceny 
                                            ON uczniowie.iduczniowie=oceny.iducznia AND oceny.idprzedmiot = $subject 
                                            WHERE uczniowie.idklasy = $grade 
                                            GROUP BY uczniowie.iduczniowie 
                                            ORDER BY uczniowie.nazwisko;");
                                        $i = 1;
                                    ?>
                                    <?php while($row = $students->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row["imie"] ?> <?= $row["nazwisko"] ?></td>
                                            <td><?= $row["oceny"]?></th>
                                            <td><input type="text" name="mark[<?= $row1["idprzedmioty"] ?>][<?= $row["iduczniowie"] ?>]" class="validate"></td>
                                            <td><input type="text" name="desc[<?= $row1["idprzedmioty"] ?>][<?= $row["iduczniowie"] ?>]" class="validate"></td>
                                            <?php $i++; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endwhile; ?>
                        <?php $grades->data_seek(0); ?>
                    <?php endwhile; ?>
                    <button class="btn waves-effect waves-light" type="submit">Wystaw oceny</button>
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