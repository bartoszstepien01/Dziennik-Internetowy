<?php
    require_once "sprawdz_nauczyciel.php"; 
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

        td {
            padding-top: 7.5px;
            padding-bottom: 7.5px;
        }
    </style>
    <?php include "components/navbar.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Podgląd ocen</h3>
            <div class="card" style="padding: 1rem;">
                <?php while($row1 = $subjects->fetch_assoc()): ?>
                    <h4><?= $row1["nazwa"] ?></h4>
                    <div class="divider"></div>
                    <?php while($row = $grades->fetch_assoc()): ?>
                        <h5>Klasa <?= $row["nazwa"] ?></h5>
                        <br>
                        <?php 
                            $grade_id = $row["idklasy"];
                            $students = $database->query("SELECT * FROM uczniowie WHERE idklasy = $grade_id ORDER BY nazwisko, imie;");
                        ?>
                        <?php while($student = $students->fetch_assoc()): ?>
                            <h6><?= $student["imie"] ?> <?= $student["nazwisko"] ?></h6>
                            <div class="divider"></div>
                            <table class="striped">
                                <thead>
                                    <tr>
                                        <th>Ocena</th>
                                        <th>Opis oceny</th>
                                        <th>Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $student_id = $student["iduczniowie"];
                                        $subject_id = $row1["idprzedmioty"];
                                        $marks = $database->query("SELECT * FROM oceny WHERE iducznia = $student_id AND idprzedmiot = $subject_id;")
                                    ?>
                                    <?php while($mark = $marks->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $mark["ocena"] ?></td>
                                            <td><?= $mark["opis"] ?></td>
                                            <td>
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?= $mark["idoceny"] ?>">
                                                    <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunocene.php">Usuń</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <br>
                        <?php endwhile; ?>
                        <br>
                        <div class="divider"></div>
                    <?php endwhile; ?>
                    <?php $grades->data_seek(0); ?>
                    <br>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>