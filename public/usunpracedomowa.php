<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("pracadomowa.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM pracedomowe WHERE idpracedomowe = $id;");

    redirect("pracadomowa.php");
?>