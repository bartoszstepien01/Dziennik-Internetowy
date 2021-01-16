<?php
    require_once "sprawdz_nauczyciel.php";
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
            <h3>Sprawdziany</h3>
            <h5>Podgląd</h5>
            <div class="card" style="padding: 1rem;">  
                <form action="podgladsprawdzianow.php" method="post">
                    <div class="input-field">
                        <select name="grade">
                            <?php while($row = $grades->fetch_assoc()): ?>
                                <option value="<?= $row["idklasy"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Klasa</label>
                    </div>
                    <div class="input-field">
                        <select name="subjects[]" multiple>
                            <?php while($row = $subjects->fetch_assoc()): ?>
                                <option value="<?= $row["idprzedmioty"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Przedmioty</label>
                    </div>
                    <?php $grades->data_seek(0); $subjects->data_seek(0); ?>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button> 
                </form>
            </div>
            <br>
            <h5>Dodawanie</h5>
            <div class="card" style="padding: 1rem;">  
                <form action="dodajsprawdzian.php" method="post">
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
                        <input type="text" class="datepicker" name="date">  
                        <label>Data</label>
                    </div>
                    <div class="input-field">
                        <textarea class="materialize-textarea" name="text" id="text"></textarea>
                        <label>Opis sprawdzianu</label>
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
            elems = document.querySelectorAll('.datepicker');
            M.Datepicker.init(elems, {
                firstDay: 1,
                format: "yyyy-mm-dd",
                minDate: new Date(),
                i18n: {
                    cancel: "Anuluj",
                    clear: "Wyczyść",
                    months: [
                        "styczeń",
                        "luty",
                        "marzec",
                        "kwiecień",
                        "maj",
                        "czerwiec",
                        "lipiec",
                        "sierpień",
                        "wrzesień",
                        "październik",
                        "listopad",
                        "grudzień"
                    ],
                    monthsShort: [
                        "styczeń",
                        "luty",
                        "marzec",
                        "kwiecień",
                        "maj",
                        "czerwiec",
                        "lipiec",
                        "sierpień",
                        "wrzesień",
                        "październik",
                        "listopad",
                        "grudzień"
                    ],
                    weekdays: [
                        "niedziela",
                        "poniedziałek",
                        "wtorek",
                        "środa",
                        "czwartek",
                        "piątek",
                        "sobota"
                    ],
                    weekdaysShort: [
                        "niedziela",
                        "poniedziałek",
                        "wtorek",
                        "środa",
                        "czwartek",
                        "piątek",
                        "sobota"
                    ],
                    weekdaysAbbrev: ["N", "P", "W", "Ś", "C", "P", "S"]
                }
            });
        });
    </script>
</body>
</html>