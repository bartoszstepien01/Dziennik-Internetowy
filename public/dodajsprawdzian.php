<?php 
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("sprawdziany.php");

    $subject = $_POST["subject"];
    $grades = $_POST["grade"];
    $date = $_POST["date"];
    $text = $_POST["text"];

    foreach ($grades as $index => $grade) 
        $database->query("INSERT INTO sprawdziany (idprzedmiotu, idklasy, data, opis) VALUES ($subject, $grade, '$date', '$text');");

    redirect("sprawdziany.php");
?>