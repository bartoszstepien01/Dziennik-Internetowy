<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("sprawdziany.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM sprawdziany WHERE idsprawdziany = $id;");

    redirect("sprawdziany.php");
?>