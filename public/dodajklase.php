<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("klasy.php");

    $name = $_POST["name"];

    $database->query("INSERT INTO klasy(nazwa) VALUES ('$name');");

    redirect("klasy.php");
?>