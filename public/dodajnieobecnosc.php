<?php
    require_once "sprawdz_nauczyciel.php"; 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("nieobecnosci.php");

    $date = $_POST["date"];
    $lesson = $_POST["lesson"];
    $students = $_POST["students"];

    foreach($students as $key => $value)
    {
        $database->query("INSERT INTO nieobecnosci (idlekcji, data, iducznia) VALUES ($lesson, '$date', $value);");
    }

    redirect("nieobecnosci.php");
?>