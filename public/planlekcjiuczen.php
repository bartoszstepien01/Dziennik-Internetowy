<?php 
    require_once "sprawdz_uczen.php";
    require_once "config.php";

    $weekdays = [1, 2, 3, 4, 5, 6, 0];
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
    <?php include "components/navbaruczen.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Zastępstwa</h3>
            <div class="card" style="padding: 1rem;"> 
                <?php foreach($weekdays as $index): ?> 
                    <h4><?= $weekday_names[$index] ?></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Godziny</th>
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Sala</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $grade_id = $_SESSION["user"]["idklasy"];
                                $lessons = $database->query("SELECT TIME_FORMAT(lekcje.poczatek, '%H:%i') AS poczatek, TIME_FORMAT(lekcje.koniec, '%H:%i') AS koniec, przedmioty.nazwa, uczniowie.imie, uczniowie.nazwisko, lekcje.sala 
                                    FROM lekcje 
                                    INNER JOIN przedmioty ON przedmioty.idprzedmioty = lekcje.lekcja 
                                    INNER JOIN uczniowie ON uczniowie.iduczniowie = lekcje.nauczyciel
                                    WHERE lekcje.klasa = $grade_id AND lekcje.dzien = $index;");
                            ?>
                            <?php while($lesson = $lessons->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $lesson["poczatek"] ?>-<?= $lesson["koniec"] ?></td>
                                    <td><?= $lesson["nazwa"] ?></td>
                                    <td><?= $lesson["imie"] ?> <?= $lesson["nazwisko"] ?></td>
                                    <td><?= $lesson["sala"] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>
        <br>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>