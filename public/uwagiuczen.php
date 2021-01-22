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
            <h3>Uwagi</h3>
            <div class="card" style="padding: 1rem;">  
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Nauczyciel</th>
                            <th>Treść uwagi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $student_id = $_SESSION["user"]["iduczniowie"];
                            $notes = $database->query("SELECT uwagi.tresc, uczniowie.nazwisko, uczniowie.imie FROM uwagi INNER JOIN uczniowie ON uwagi.nauczyciel = uczniowie.iduczniowie WHERE uwagi.iducznia = $student_id;");
                        ?>
                        <?php while($note = $notes->fetch_assoc()): ?>
                            <tr>
                                <td><?= $note["imie"] ?> <?= $note["nazwisko"] ?></td>
                                <td><?= $note["tresc"] ?></td>
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