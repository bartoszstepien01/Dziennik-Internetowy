<?php
    require_once "sprawdz_nauczyciel.php"; 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
    $grade = $_POST["grade"];
    $students = implode(", ", $_POST["students"]);

    $grades = $database->query("SELECT * FROM klasy WHERE idklasy = $grade ORDER BY idklasy;");
    $students = $database->query("SELECT * FROM uczniowie WHERE iduczniowie IN ($students) ORDER BY nazwisko, imie;");
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
            <h3>Podgląd uwag</h3>
            <div class="card" style="padding: 1rem;">
                    <?php while($row = $grades->fetch_assoc()): ?>
                        <h4>Klasa <?= $row["nazwa"] ?></h4>
                        <?php while($student = $students->fetch_assoc()): ?>
                            <br>
                            <h6><?= $student["imie"] ?> <?= $student["nazwisko"] ?></h6>
                            <div class="divider"></div>
                            <table class="striped">
                                <thead>
                                    <tr>
                                        <th>Nauczyciel</th>
                                        <th>Treść uwagi</th>
                                        <th>Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $student_id = $student["iduczniowie"];
                                        $notes = $database->query("SELECT uwagi.iduwagi, uwagi.tresc, uczniowie.nazwisko, uczniowie.imie FROM uwagi INNER JOIN uczniowie ON uwagi.nauczyciel = uczniowie.iduczniowie WHERE uwagi.iducznia = $student_id;");
                                    ?>
                                    <?php while($note = $notes->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $note["imie"] ?> <?= $note["nazwisko"] ?></td>
                                            <td><?= $note["tresc"] ?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?= $note["iduwagi"] ?>">
                                                    <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunuwage.php" onclick="fetch('/usunuwage.php',{method: 'post', body: {id: <?= $note["iduwagi"] ?>}}).then(()=>location.reload());">Usuń</button>
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
        <br>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>