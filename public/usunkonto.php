<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("konta.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM uczniowie WHERE iduczniowie = $id;");

    redirect("konta.php");
?>