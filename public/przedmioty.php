<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    $grades = $database->query("SELECT * FROM przedmioty;");
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
    <?php include "components/navbar.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Konta</h3>
            <h5>Podgląd</h5>
            <div class="card" style="padding: 1rem;">  
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($grade = $grades->fetch_assoc()): ?>
                            <tr>
                                <td><?= $grade["nazwa"] ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= $grade["idprzedmioty"] ?>">
                                        <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunprzedmiot.php">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <br>
            <h5>Dodawanie</h5>
            <div class="card" style="padding: 1rem;">  
                <form action="dodajprzedmiot.php" method="post">
                    <div class="input-field">
                        <input type="text" name="name">
                        <label>Nazwa</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button>
                </form>
            </div>
            <br>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>