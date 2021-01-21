<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("oceny.php");
    
    $id = $_POST["id"];

    $database->query("DELETE FROM oceny WHERE idoceny = $id;");

    redirect("oceny.php");
?>