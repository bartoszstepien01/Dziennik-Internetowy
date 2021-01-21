<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("przedmioty.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM przedmioty WHERE idprzedmioty = $id;");

    redirect("przedmioty.php");
?>