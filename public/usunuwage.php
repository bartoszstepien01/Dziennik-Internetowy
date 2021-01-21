<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("uwagi.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM uwagi WHERE iduwagi = $id;");

    redirect("uwagi.php");
?>