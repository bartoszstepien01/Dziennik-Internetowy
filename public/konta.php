<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    $accounts = $database->query("SELECT iduczniowie, nazwisko, imie, uprawnienia, nazwa FROM uczniowie LEFT JOIN klasy ON uczniowie.idklasy = klasy.idklasy ORDER BY uprawnienia, uczniowie.idklasy, nazwisko, imie;");
    $grades = $database->query("SELECT * FROM klasy;");
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
                            <th>Nazwisko</th>
                            <th>Imię</th>
                            <th>Klasa</th>
                            <th>Uprawnienia</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($account = $accounts->fetch_assoc()): ?>
                            <tr>
                                <td><?= $account["nazwisko"] ?></td>
                                <td><?= $account["imie"] ?></td>
                                <td><?= $account["nazwa"] ?></td>
                                <td><?= $permissions[$account["uprawnienia"]] ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= $account["iduczniowie"] ?>">
                                        <?php if($account["iduczniowie"] != $_SESSION["user"]["iduczniowie"]): ?>
                                            <button class="btn-small waves-effect waves-light red" type="submit" formaction="usunkonto.php">Usuń</button>
                                        <?php endif; ?>
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
                <form action="dodajkonto.php" method="post">
                    <div class="input-field">
                        <input type="text" name="surname">
                        <label>Nazwisko</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="name">
                        <label>Imię</label>
                    </div>
                    <div class="input-field">
                        <select id="grade" name="grade">
                            <?php while($row = $grades->fetch_assoc()): ?>
                                <option value="<?= $row["idklasy"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Klasa</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="login">
                        <label>Login</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password">
                        <label>Hasło</label>
                    </div>
                    <div class="input-field">
                        <select id="type" onchange="checkType();" name="type">
                            <option value="0">uczeń</option>
                            <option value="1">nauczyciel</option>
                        </select>
                        <label>Typ konta</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button>
                </form>
            </div>
            <br>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });

        function checkType() {
            let type = document.querySelector("#type");
            let grade = document.querySelector("#grade");
            if(type.value == 1)
                grade.disabled = true;
            else
                grade.disabled = false;
            let elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        }
    </script>
</body>
</html>