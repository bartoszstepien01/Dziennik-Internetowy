<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("nieobecnosci.php");
    
    $id = $_POST["id"];

    $database->query("UPDATE nieobecnosci SET usprawiedliwione = 1 WHERE idnieobecnosci = $id;");

    redirect("nieobecnosci.php");
?>