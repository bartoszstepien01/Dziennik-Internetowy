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
            <h3>Nieobecności</h3>
            <div class="card" style="padding: 1rem;">  
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Dzień</th>
                            <th>Lekcja</th>
                            <th>Usprawiedliwione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $student_id = $_SESSION["user"]["iduczniowie"];
                            $database->query("SET lc_time_names = 'pl_PL';");
                            $absences = $database->query("SELECT DATE_FORMAT(nieobecnosci.data, '%W, %d.%m.%Y r.') AS data, przedmioty.nazwa AS nazwa, usprawiedliwione FROM nieobecnosci INNER JOIN lekcje ON lekcje.idlekcje = nieobecnosci.idlekcji INNER JOIN przedmioty ON lekcje.lekcja = przedmioty.idprzedmioty WHERE iducznia = $student_id;");
                        ?>
                        <?php while($absence = $absences->fetch_assoc()): ?>
                            <tr>
                                <td><?= $absence["data"] ?></td>
                                <td><?= $absence["nazwa"] ?></td>
                                <td><?= $absence["usprawiedliwione"] ? "tak" : "nie" ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>