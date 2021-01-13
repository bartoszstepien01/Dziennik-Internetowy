<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("zastepstwa.php");

    $date = $_POST["date"];
    $lesson = $_POST["lesson"];
    $teacher = $_POST["teacher"];
    $subject = $_POST["subject"];
    $classroom = $_POST["classroom"];

    $database->query("INSERT INTO zastepstwa (idlekcji, data, idprzedmiotu, nauczyciel, sala) VALUES ($lesson, '$date', $subject, $teacher, '$classroom');");

    redirect("zastepstwa.php");
?>