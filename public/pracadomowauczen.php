<?php 
    require_once "sprawdz_uczen.php";
    require_once "config.php";

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
    <?php include "components/navbaruczen.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Praca domowa</h3>
            <div class="card" style="padding: 1rem;">  
                <?php while($subject = $subjects->fetch_assoc()): ?>
                    <h4><?= $subject["nazwa"] ?></h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Termin</th>
                                <th>Opis pracy domowej</th>
                                <th>Nauczyciel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $subject_id = $subject["idprzedmioty"];
                                $grade_id = $_SESSION["user"]["idklasy"];
                                $database->query("SET lc_time_names = 'pl_PL';");
                                $homework = $database->query("SELECT DATE_FORMAT(pracedomowe.data, '%W, %d.%m.%Y r.') AS data, pracedomowe.opis, uczniowie.nazwisko, uczniowie.imie FROM pracedomowe INNER JOIN uczniowie ON uczniowie.iduczniowie = pracedomowe.nauczyciel WHERE pracedomowe.idprzedmiotu = $subject_id AND pracedomowe.idklasy = $grade_id;");
                            ?>
                            <?php while($hw = $homework->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $hw["data"] ?></td>
                                    <td><?= $hw["opis"] ?></td>
                                    <td><?= $hw["imie"] ?> <?= $hw["nazwisko"] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <br>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>