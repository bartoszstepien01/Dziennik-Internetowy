<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("planlekcji.php");

    $subject = $_POST["subject"];
    $grades = $_POST["grade"];
    $weekday = $_POST["weekday"];
    $beginning = $_POST["beginning"].":00";
    $end = $_POST["end"].":00";
    $classroom = $_POST["classroom"];

    foreach ($grades as $index => $grade) 
        $database->query("INSERT INTO lekcje (dzien, poczatek, koniec, lekcja, klasa, sala) VALUES ($weekday, '$beginning', '$end', $subject, $grade, '$classroom');");

    redirect("planlekcji.php");
?>