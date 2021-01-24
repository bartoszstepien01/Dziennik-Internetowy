<?php 
    require_once "sprawdz_uczen.php";
    require_once "config.php";
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
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Godzina</th>
                            <th>Przedmiot</th>
                            <th>Nauczyciel</th>
                            <th>Sala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $grade_id = $_SESSION["user"]["idklasy"];
                            $database->query("SET lc_time_names = 'pl_PL';");
                            $substitutions = $database->query("SELECT DATE_FORMAT(zastepstwa.data, '%W, %d.%m.%Y r.') AS data ,TIME_FORMAT(lekcje.poczatek, '%H:%i') AS poczatek, TIME_FORMAT(lekcje.koniec, '%H:%i') AS koniec, przedmioty.nazwa, uczniowie.imie, uczniowie.nazwisko, zastepstwa.sala 
                                FROM zastepstwa 
                                INNER JOIN lekcje ON zastepstwa.idlekcji = lekcje.idlekcje 
                                INNER JOIN przedmioty ON zastepstwa.idprzedmiotu = przedmioty.idprzedmioty 
                                INNER JOIN uczniowie ON zastepstwa.nauczyciel = uczniowie.iduczniowie 
                                WHERE lekcje.klasa = $grade_id AND DATE(zastepstwa.data) >= CURDATE();");
                        ?>
                        <?php while($substitution = $substitutions->fetch_assoc()): ?>
                            <tr>
                                <td><?= $substitution["data"] ?></td>
                                <td><?= $substitution["poczatek"] ?>-<?= $substitution["koniec"] ?></td>
                                <td><?= $substitution["nazwa"] ?></td>
                                <td><?= $substitution["imie"] ?> <?= $substitution["nazwisko"] ?></td>
                                <td><?= $substitution["sala"] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>