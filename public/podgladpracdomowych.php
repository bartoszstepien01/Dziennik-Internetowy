<?php
    require_once "sprawdz_nauczyciel.php"; 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
    $grade = $_POST["grade"];
    $subjects = implode(", ", $_POST["subjects"]);

    $grades = $database->query("SELECT * FROM klasy WHERE idklasy = $grade ORDER BY idklasy;");
    $subjects = $database->query("SELECT * FROM przedmioty WHERE idprzedmioty IN ($subjects);");
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

        td {
            padding-top: 7.5px;
            padding-bottom: 7.5px;
        }
    </style>
    <?php include "components/navbar.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Podgląd prac domowych</h3>
            <div class="card" style="padding: 1rem;">
                    <?php while($row = $grades->fetch_assoc()): ?>
                        <h4>Klasa <?= $row["nazwa"] ?></h4>
                        <?php while($subject = $subjects->fetch_assoc()): ?>
                            <br>
                            <h6><?= $subject["nazwa"] ?></h6>
                            <div class="divider"></div>
                            <table class="striped">
                                <thead>
                                    <tr>
                                        <th>Termin</th>
                                        <th>Opis pracy domowej</th>
                                        <th>Nauczyciel</th>
                                        <th>Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $subject_id = $subject["idprzedmioty"];
                                        $grade_id = $row["idklasy"];
                                        $database->query("SET lc_time_names = 'pl_PL';");
                                        $homework = $database->query("SELECT idpracedomowe, DATE_FORMAT(pracedomowe.data, '%W, %d.%m.%Y r.') AS data, pracedomowe.opis, uczniowie.nazwisko, uczniowie.imie FROM pracedomowe INNER JOIN uczniowie ON uczniowie.iduczniowie = pracedomowe.nauczyciel WHERE pracedomowe.idprzedmiotu = $subject_id AND pracedomowe.idklasy = $grade_id;");
                                    ?>
                                    <?php while($hw = $homework->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $hw["data"] ?></td>
                                            <td><?= $hw["opis"] ?></td>
                                            <td><?= $hw["imie"] ?> <?= $hw["nazwisko"] ?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?= $hw["idpracedomowe"] ?>">
                                                    <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunpracedomowa.php">Usuń</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <br>
                        <?php endwhile; ?>
                    <?php endwhile; ?>
                    <br>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>