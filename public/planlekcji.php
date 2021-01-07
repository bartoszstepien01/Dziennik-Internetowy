<?php 
    require_once "config.php";

    $grades = $database->query("SELECT * FROM klasy;");
    $subjects = $database->query("SELECT * FROM przedmioty;");
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
            <h3>Edycja planu lekcji</h3>
            <div class="card" style="padding: 1rem;">  
                <form action="dodajlekcje.php" method="post">
                    <div class="input-field">
                        <select name="subject">
                            <?php while($row = $subjects->fetch_assoc()): ?>
                                <option value="<?= $row["idprzedmioty"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Przedmiot</label>
                    </div>
                    <div class="input-field">
                        <select multiple name="grade[]">
                            <?php while($row = $grades->fetch_assoc()): ?>
                                <option value="<?= $row["idklasy"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Klasa</label>
                    </div>
                    <div class="input-field">
                        <select name="weekday">
                            <option value="1">poniedziałek</option>
                            <option value="2">wtorek</option>
                            <option value="3">środa</option>
                            <option value="4">czwartek</option>
                            <option value="5">piątek</option>
                            <option value="6">sobota</option>
                            <option value="0">niedziela</option>
                        </select>
                        <label>Dzień tygodnia</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="timepicker" name="beginning">
                        <label>Początek lekcji</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="timepicker" name="end">
                        <label>Koniec lekcji</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="classroom">
                        <label>Sala</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
            elems = document.querySelectorAll('.timepicker');
            M.Timepicker.init(elems, {
                twelveHour: false,
                i18n: {
                    cancel: "Anuluj",
                    clear: "Wyczyść",
                    done: "OK"
                }
            });
        });
    </script>
</body>
</html>