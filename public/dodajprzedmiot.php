<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("przedmioty.php");

    $name = $_POST["name"];

    $database->query("INSERT INTO przedmioty(nazwa) VALUES ('$name');");

    redirect("przedmioty.php");
?>