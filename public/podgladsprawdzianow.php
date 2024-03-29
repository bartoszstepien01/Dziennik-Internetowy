<?php
    require_once "sprawdz_nauczyciel.php"; 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
    $grades = implode(", ", $_POST["grades"]);
    $teachers = implode(", ", $_POST["teachers"]);
    $subjects = implode(", ", $_POST["subjects"]);

    if($grades != "") $grades = $database->query("SELECT * FROM klasy WHERE idklasy IN ($grades);");
    else $grades = $database->query("SELECT * FROM klasy WHERE idklasy = NULL;");
    $subjects = $database->query("SELECT * FROM przedmioty WHERE idprzedmioty IN ($subjects);");
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
            <h3>Podgląd sprawdzianów</h3>
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
                                    <th>Dzień</th>
                                    <th>Opis sprawdzianu</th>
                                    <th>Nauczyciel</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $subject_id = $subject["idprzedmioty"];
                                    $grade_id = $row["idklasy"];
                                    $database->query("SET lc_time_names = 'pl_PL';");
                                    $tests = $database->query("SELECT idsprawdziany, DATE_FORMAT(sprawdziany.data, '%W, %d.%m.%Y r.') AS data, sprawdziany.opis, uczniowie.nazwisko, uczniowie.imie FROM sprawdziany INNER JOIN uczniowie ON uczniowie.iduczniowie = sprawdziany.nauczyciel WHERE sprawdziany.idprzedmiotu = $subject_id AND sprawdziany.idklasy = $grade_id AND DATE(sprawdziany.data) >= CURDATE();");
                                ?>
                                <?php while($test = $tests->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $test["data"] ?></td>
                                        <td><?= $test["opis"] ?></td>
                                        <td><?= $test["imie"] ?> <?= $test["nazwisko"] ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $test["idsprawdziany"] ?>">
                                                <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunsprawdzian.php" onclick="fetch('/usunsprawdzian.php',{method: 'post', body: {id: <?= $test["idsprawdziany"] ?>}}).then(()=>location.reload());">Usuń</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <br>
                    <?php endwhile; ?>
                    <?php $subjects->data_seek(0); ?>
                <?php endwhile; ?>
                <?php while($row = $teachers->fetch_assoc()): ?>
                    <h4><?= $row["imie"] ?> <?= $row["nazwisko"] ?></h4>
                    <?php while($subject = $subjects->fetch_assoc()): ?>
                        <br>
                        <h6><?= $subject["nazwa"] ?></h6>
                        <div class="divider"></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Dzień</th>
                                    <th>Opis sprawdzianu</th>
                                    <th>Klasa</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $subject_id = $subject["idprzedmioty"];
                                    $teacher_id = $row["iduczniowie"];
                                    $database->query("SET lc_time_names = 'pl_PL';");
                                    $tests = $database->query("SELECT idsprawdziany, DATE_FORMAT(sprawdziany.data, '%W, %d.%m.%Y r.') AS data, sprawdziany.opis, klasy.nazwa FROM sprawdziany INNER JOIN klasy ON klasy.idklasy = sprawdziany.idklasy WHERE sprawdziany.idprzedmiotu = $subject_id AND sprawdziany.nauczyciel = $teacher_id AND DATE(pracedomowe.data) >= CURDATE();");
                                ?>
                                <?php while($test = $tests->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $test["data"] ?></td>
                                        <td><?= $test["opis"] ?></td>
                                        <td><?= $test["nazwa"] ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="id" value="<?= $test["idsprawdziany"] ?>">
                                                <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunsprawdzian.php" onclick="fetch('/usunsprawdzian.php',{method: 'post', body: {id: <?= $test["idsprawdziany"] ?>}}).then(()=>location.reload());">Usuń</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endwhile; ?>
                    <?php $subjects->data_seek(0); ?>
                <?php endwhile; ?>
                <br>
            </div>
        </div>
        <br>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>