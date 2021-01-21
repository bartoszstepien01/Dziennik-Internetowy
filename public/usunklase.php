<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("klasy.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM klasy WHERE idklasy = $id;");

    redirect("klasy.php");
?>