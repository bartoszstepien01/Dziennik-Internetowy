<?php 
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

        input {
            margin: 0 !important;
        }

        td {
            padding-top: 7.5px;
            padding-bottom: 7.5px;
        }
    </style>
    <?php include "components/navbar.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Wstawianie ocen</h3>
            <div class="card" style="padding: 1rem;">
                <form action="wystawoceny.php" method="post">
                    <?php while($row1 = $subjects->fetch_assoc()): ?>
                        <h4><?= $row1["nazwa"] ?></h4>
                        <div class="divider"></div>
                        <?php while($row = $grades->fetch_assoc()): ?>
                            <h5>Klasa <?= $row["nazwa"] ?></h5>
                            <table class="striped">
                                <thead>
                                    <tr>
                                        <th>Lp.</th>
                                        <th>Imię i nazwisko</th>
                                        <th>Oceny</th>
                                        <th>Ocena wstawiana</th>
                                        <th>Opis oceny</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $grade = $row["idklasy"];
                                        $subject = $row1["idprzedmioty"];
                                        $students = $database->query("SELECT 
                                                uczniowie.iduczniowie, 
                                                uczniowie.nazwisko, 
                                                uczniowie.imie, 
                                                GROUP_CONCAT(oceny.ocena ORDER BY oceny.idoceny SEPARATOR ', ') AS oceny 
                                            FROM uczniowie 
                                            LEFT JOIN oceny 
                                            ON uczniowie.iduczniowie=oceny.iducznia AND oceny.idprzedmiot = $subject 
                                            WHERE uczniowie.idklasy = $grade 
                                            GROUP BY uczniowie.iduczniowie 
                                            ORDER BY uczniowie.nazwisko, uczniowie.imie;");
                                        $i = 1;
                                    ?>
                                    <?php while($row = $students->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $row["imie"] ?> <?= $row["nazwisko"] ?></td>
                                            <td><?= $row["oceny"]?></th>
                                            <td><input type="text" name="mark[<?= $row1["idprzedmioty"] ?>][<?= $row["iduczniowie"] ?>]" class="validate"></td>
                                            <td><input type="text" name="desc[<?= $row1["idprzedmioty"] ?>][<?= $row["iduczniowie"] ?>]" class="validate"></td>
                                            <?php $i++; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <br>
                            <div class="divider"></div>
                        <?php endwhile; ?>
                        <?php $grades->data_seek(0); ?>
                        <br>
                    <?php endwhile; ?>
                    <button class="btn waves-effect waves-light" type="submit">Wystaw oceny</button>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>