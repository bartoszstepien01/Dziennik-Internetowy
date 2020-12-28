<?php 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("uwagi.php");

    $students = $_POST["student"];
    $text = $_POST["text"];

    foreach ($students as $index => $student) 
        $database->query("INSERT INTO uwagi (iducznia, tresc) VALUES ($student, '$text');");

    redirect("uwagi.php");
?>