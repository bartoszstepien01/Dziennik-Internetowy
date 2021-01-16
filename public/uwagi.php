<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    $students = $database->query("SELECT uczniowie.iduczniowie, uczniowie.imie, uczniowie.nazwisko, klasy.nazwa FROM uczniowie INNER JOIN klasy ON uczniowie.idklasy = klasy.idklasy ORDER BY uczniowie.idklasy, nazwisko, imie;");
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
            <h3>Uwagi</h3>
            <h5>Podgląd</h5>
            <div class="card" style="padding: 1rem;">  
                <form action="podgladuwag.php" method="post">
                    <div class="input-field">
                        <select id="grade2" name="grade" onchange="fetchStudents();">
                            <?php while($row = $grades->fetch_assoc()): ?>
                                <option value="<?= $row["idklasy"] ?>"><?= $row["nazwa"] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label>Klasa</label>
                    </div>
                    <?php $grades->data_seek(0); ?>
                    <div class="input-field">
                        <select name="students[]" id="students2" multiple>
                        </select>
                        <label>Uczniowie</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button> 
                </form>
            </div>
            <br>
            <h5>Wstawianie</h5>
            <div class="card" style="padding: 1rem;">  
                <form action="wstawuwage.php" method="post">
                    <div class="input-field">
                        <select multiple name="student[]">
                            <?php while($row = $students->fetch_assoc()): ?>
                                <option value="<?= $row["iduczniowie"] ?>"><?= $row["imie"] ?> <?= $row["nazwisko"] ?> (<?= $row["nazwa"] ?>)</option>
                            <?php endwhile; ?>
                        </select>
                        <label>Uczeń</label>
                    </div>
                    <div class="input-field">
                        <textarea class="materialize-textarea" name="text" id="text"></textarea>
                        <label>Treść uwagi</label>
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
            fetchStudents();
        });

        function fetchStudents()
        {
            let grade = document.querySelector("#grade2");
            let students = document.querySelector("#students2");
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
        }
    </script>
</body>
</html>