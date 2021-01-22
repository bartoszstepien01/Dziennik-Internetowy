<?php
    require_once "sprawdz_nauczyciel.php"; 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
    $grades = implode(", ", $_POST["grades"]);
    $teachers = implode(", ", $_POST["teachers"]);
    $weekdays = $_POST["weekdays"];

    if($grades != "") $grades = $database->query("SELECT * FROM klasy WHERE idklasy IN ($grades);");
    else $grades = $database->query("SELECT * FROM klasy WHERE idklasy = NULL;");
    $teachers = $database->query("SELECT * FROM uczniowie WHERE iduczniowie IN ($teachers);");
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
        td {
            padding-top: 7.5px;
            padding-bottom: 7.5px;
        }

        table {
            table-layout: fixed;
        }
    </style>
    <?php include "components/navbar.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Podgląd planu lekcji</h3>
            <div class="card" style="padding: 1rem;">
                <?php while($row = $grades->fetch_assoc()): ?>
                    <h4>Klasa <?= $row["nazwa"] ?></h4>
                    <?php foreach($weekdays as $weekday): ?>
                        <br>
                        <h6><?= $weekday_names[$weekday] ?></h6>
                        <table>
                            <thead>
                                <tr>
                                    <th>Godziny</th>
                                    <th>Przedmiot</th>
                                    <th>Nauczyciel</th>
                                    <th>Sala</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $grade_id = $row["idklasy"];
                                    $lessons = $database->query("SELECT idlekcje, TIME_FORMAT(lekcje.poczatek, '%H:%i') AS poczatek, TIME_FORMAT(lekcje.koniec, '%H:%i') AS koniec, przedmioty.nazwa, uczniowie.imie, uczniowie.nazwisko, lekcje.sala 
                                        FROM lekcje 
                                        INNER JOIN przedmioty ON przedmioty.idprzedmioty = lekcje.lekcja 
                                        INNER JOIN uczniowie ON uczniowie.iduczniowie = lekcje.nauczyciel
                                        WHERE lekcje.klasa = $grade_id AND lekcje.dzien = $weekday;");
                                ?>
                                <?php while($lesson = $lessons->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $lesson["poczatek"] ?>-<?= $lesson["koniec"] ?></td>
                                        <td><?= $lesson["nazwa"] ?></td>
                                        <td><?= $lesson["imie"] ?> <?= $lesson["nazwisko"] ?></td>
                                        <td><?= $lesson["sala"] ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $lesson["idlekcje"] ?>">
                                                <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunlekcje.php" onclick="fetch('/usunlekcje.php',{method: 'post', body: {id: <?= $lesson["idlekcje"] ?>}}).then(()=>location.reload());">Usuń</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                <?php endwhile; ?>
                <?php while($row = $teachers->fetch_assoc()): ?>
                    <h4><?= $row["imie"] ?> <?= $row["nazwisko"] ?></h4>
                    <?php foreach($weekdays as $weekday): ?>
                        <br>
                        <h6><?= $weekday_names[$weekday] ?></h6>
                        <table>
                            <thead>
                                <tr>
                                    <th>Godziny</th>
                                    <th>Przedmiot</th>
                                    <th>Klasa</th>
                                    <th>Sala</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $teacher_id = $row["iduczniowie"];
                                    $lessons = $database->query("SELECT idlekcje, TIME_FORMAT(lekcje.poczatek, '%H:%i') AS poczatek, TIME_FORMAT(lekcje.koniec, '%H:%i') AS koniec, przedmioty.nazwa, klasy.nazwa AS nazwisko, lekcje.sala 
                                        FROM lekcje 
                                        INNER JOIN przedmioty ON przedmioty.idprzedmioty = lekcje.lekcja 
                                        INNER JOIN klasy ON klasy.idklasy = lekcje.klasa
                                        WHERE lekcje.nauczyciel = $teacher_id AND lekcje.dzien = $weekday;");
                                ?>
                                <?php while($lesson = $lessons->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $lesson["poczatek"] ?>-<?= $lesson["koniec"] ?></td>
                                        <td><?= $lesson["nazwa"] ?></td>
                                        <td><?= $lesson["nazwisko"] ?></td>
                                        <td><?= $lesson["sala"] ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $lesson["idlekcje"] ?>">
                                                <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunlekcje.php" onclick="fetch('/usunlekcje.php',{method: 'post', body: {id: <?= $lesson["idlekcje"] ?>}}).then(()=>location.reload());">Usuń</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                <?php endwhile; ?>
                <br>
            </div>
        </div>
        <br>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>