<?php 
    require_once "sprawdz_uczen.php";
    require_once "config.php";

    $grade_id = $_SESSION["user"]["idklasy"];

    $subjects = $database->query("SELECT idprzedmioty, nazwa FROM przydzialy INNER JOIN przedmioty ON idprzedmiotu = idprzedmioty WHERE idklasy = $grade_id;");
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
            <h3>Sprawdziany</h3>
            <div class="card" style="padding: 1rem;">
                <?php while($subject = $subjects->fetch_assoc()): ?>
                    <h4><?= $subject["nazwa"] ?></h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Dzień</th>
                                <th>Opis sprawdzianu</th>
                                <th>Nauczyciel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $subject_id = $subject["idprzedmioty"];
                                $grade_id = $_SESSION["user"]["idklasy"];
                                $database->query("SET lc_time_names = 'pl_PL';");
                                $tests = $database->query("SELECT DATE_FORMAT(sprawdziany.data, '%W, %d.%m.%Y r.') AS data, sprawdziany.opis, uczniowie.nazwisko, uczniowie.imie FROM sprawdziany INNER JOIN uczniowie ON uczniowie.iduczniowie = sprawdziany.nauczyciel WHERE sprawdziany.idprzedmiotu = $subject_id AND sprawdziany.idklasy = $grade_id AND DATE(sprawdziany.data) >= CURDATE();");
                            ?>
                            <?php while($test = $tests->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $test["data"] ?></td>
                                    <td><?= $test["opis"] ?></td>
                                    <td><?= $test["imie"] ?> <?= $test["nazwisko"] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <br>
                <?php endwhile; ?>
            </div>
        </div>
        <br>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>