<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("uwagi.php");

    $students = $_POST["student"];
    $text = $_POST["text"];
    $teacher_id = $_SESSION["user"]["iduczniowie"];

    foreach ($students as $index => $student) 
        $database->query("INSERT INTO uwagi (iducznia, tresc, nauczyciel) VALUES ($student, '$text', $teacher_id);");

    redirect("uwagi.php");
?>