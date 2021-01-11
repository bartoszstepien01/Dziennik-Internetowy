<?php 
    require_once "config.php";

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
            <h3>Wstawianie nieobecności</h3>
            <div class="card" style="padding: 1rem;">  
                <form action="dodajnieobecnosc.php" method="post">
                    <div class="input-field">
                        <select id="grade" onchange="fetchData();">
                            <?php while($row = $grades->fetch_assoc()): ?>
                                <option value="<?= $row["idklasy"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Klasa</label>
                    </div>
                    <div class="input-field">
                        <input type="text" class="datepicker" name="date" id="date" onchange="fetchData();">  
                        <label>Data</label>
                    </div>
                    <div class="input-field">
                        <select name="lesson" id="lesson">
                        </select>
                        <label>Lekcja</label>
                    </div>
                    <div class="input-field">
                        <select name="students[]" id="students" multiple>
                        </select>
                        <label>Uczniowie</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let grade = document.querySelector("#grade");
            let students = document.querySelector("#students");

            fetch(`/api/pobierzuczniow.php?grade=${grade.value}`)
                .then(response => response.json())
                .then(response => {
                    students.innerHTML = "";
                    response.forEach(student => {
                        var el = document.createElement("option");
                        el.textContent = student.imie + " " + student.nazwisko;
                        el.value = student.iduczniowie;
                        students.appendChild(el);
                    })
                    M.FormSelect.init(students);
                });

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

        function fetchData()
        {
            let grade = document.querySelector("#grade");
            let date = document.querySelector("#date");
            let lessons = document.querySelector("#lesson");
            let students = document.querySelector("#students");

            let day = new Date(date.value);

            fetch(`/api/pobierzlekcje.php?grade=${grade.value}&day=${day.getDay()}`)
                .then(response => response.json())
                .then(response => {
                    lesson.innerHTML = "";
                    response.forEach(lesson => {
                        var el = document.createElement("option");
                        el.textContent = lesson.nazwa;
                        el.value = lesson.idlekcje;
                        lessons.appendChild(el);
                    })
                    M.FormSelect.init(lessons);
                });
            
            fetch(`/api/pobierzuczniow.php?grade=${grade.value}`)
                .then(response => response.json())
                .then(response => {
                    students.innerHTML = "";
                    response.forEach(student => {
                        var el = document.createElement("option");
                        el.textContent = student.imie + " " + student.nazwisko;
                        el.value = student.iduczniowie;
                        students.appendChild(el);
                    })
                    M.FormSelect.init(students);
                });
        };
    </script>
</body>
</html>