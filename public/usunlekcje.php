<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("planlekcji.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM lekcje WHERE idlekcje = $id;");

    redirect("planlekcji.php");
?>