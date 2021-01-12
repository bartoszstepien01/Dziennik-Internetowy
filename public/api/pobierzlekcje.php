<?php
    require_once "../sprawdz_nauczyciel.php"; 
    require_once "../config.php";

    $grade = $_GET["grade"];
    $day = $_GET["day"];
    $array = [];

    $lessons = $database->query("SELECT lekcje.*, przedmioty.nazwa FROM lekcje INNER JOIN przedmioty ON lekcje.lekcja = przedmioty.idprzedmioty WHERE klasa = $grade AND dzien = $day ORDER BY lekcje.poczatek;");
    while($row = $lessons->fetch_assoc())
        $array[] = $row;

    echo json_encode($array);
?>