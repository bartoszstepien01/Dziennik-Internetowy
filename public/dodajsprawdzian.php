<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("sprawdziany.php");

    $subject = $_POST["subject"];
    $grades = $_POST["grade"];
    $date = $_POST["date"];
    $text = $_POST["text"];
    $teacher_id = $_SESSION["user"]["iduczniowie"];

    foreach ($grades as $index => $grade) 
        $database->query("INSERT INTO sprawdziany (idprzedmiotu, idklasy, data, opis, nauczyciel) VALUES ($subject, $grade, '$date', '$text', $teacher_id);");

    redirect("sprawdziany.php");
?>