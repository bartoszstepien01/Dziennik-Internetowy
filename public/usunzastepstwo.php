<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("zastepstwa.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM zastepstwa WHERE idzastepstwa = $id;");

    redirect("zastepstwa.php");
?>