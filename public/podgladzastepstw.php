<?php
    require_once "sprawdz_nauczyciel.php"; 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
    $grades = implode(", ", $_POST["grades"]);
    $teachers = implode(", ", $_POST["teachers"]);
    $date = $_POST["date"];

    $grades = $database->query("SELECT * FROM klasy WHERE idklasy IN ($grades);");
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
            <h3>Podgląd zastępstw</h3>
            <div class="card" style="padding: 1rem;">
                <?php while($row = $grades->fetch_assoc()): ?>
                    <h4>Klasa <?= $row["nazwa"] ?></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Godzina</th>
                                <th>Przedmiot</th>
                                <th>Nauczyciel</th>
                                <th>Sala</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $grade_id = $row["idklasy"];
                                $substitutions = $database->query("SELECT TIME_FORMAT(lekcje.poczatek, '%H:%i') AS poczatek, TIME_FORMAT(lekcje.koniec, '%H:%i') AS koniec, przedmioty.nazwa, uczniowie.imie, uczniowie.nazwisko, zastepstwa.sala 
                                    FROM zastepstwa 
                                    INNER JOIN lekcje ON zastepstwa.idlekcji = lekcje.idlekcje 
                                    INNER JOIN przedmioty ON zastepstwa.idprzedmiotu = przedmioty.idprzedmioty 
                                    INNER JOIN uczniowie ON zastepstwa.nauczyciel = uczniowie.iduczniowie 
                                    WHERE lekcje.klasa = $grade_id AND zastepstwa.data = '$date';");
                            ?>
                            <?php while($substitution = $substitutions->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $substitution["poczatek"] ?>-<?= $substitution["koniec"] ?></td>
                                    <td><?= $substitution["nazwa"] ?></td>
                                    <td><?= $substitution["imie"] ?> <?= $substitution["nazwisko"] ?></td>
                                    <td><?= $substitution["sala"] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endwhile; ?>
                <?php while($row = $teachers->fetch_assoc()): ?>
                    <h4><?= $row["imie"] ?> <?= $row["nazwisko"] ?></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Godzina</th>
                                <th>Przedmiot</th>
                                <th>Klasa</th>
                                <th>Sala</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $teacher_id = $row["iduczniowie"];
                                $substitutions = $database->query("SELECT TIME_FORMAT(lekcje.poczatek, '%H:%i') AS poczatek, TIME_FORMAT(lekcje.koniec, '%H %i') AS koniec, przedmioty.nazwa, klasy.nazwa AS nazwisko, zastepstwa.sala 
                                    FROM zastepstwa 
                                    INNER JOIN lekcje ON zastepstwa.idlekcji = lekcje.idlekcje 
                                    INNER JOIN przedmioty ON zastepstwa.idprzedmiotu = przedmioty.idprzedmioty 
                                    INNER JOIN klasy ON lekcje.klasa = klasy.idklasy 
                                    WHERE zastepstwa.nauczyciel = $teacher_id AND zastepstwa.data = '$date';");
                            ?>
                            <?php while($substitution = $substitutions->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $substitution["poczatek"] ?>-<?= $substitution["koniec"] ?></td>
                                    <td><?= $substitution["nazwa"] ?></td>
                                    <td><?= $substitution["nazwisko"] ?></td>
                                    <td><?= $substitution["sala"] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endwhile; ?>
                <br>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>