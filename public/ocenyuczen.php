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
            <h3>Oceny</h3>
            <div class="card" style="padding: 1rem;">  
                <?php while($subject = $subjects->fetch_assoc()): ?>
                    <h4><?= $subject["nazwa"] ?></h4>
                    <?php
                        $subject_id = $subject["idprzedmioty"];
                        $student_id = $_SESSION["user"]["iduczniowie"];
                        $marks = $database->query("SELECT * FROM oceny WHERE idprzedmiot = $subject_id AND iducznia = $student_id;");
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Ocena</th>
                                <th>Opis oceny</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($mark = $marks->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $mark["ocena"] ?></td>
                                    <td><?= $mark["opis"] ?></td>
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