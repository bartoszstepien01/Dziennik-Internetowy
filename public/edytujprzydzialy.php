<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("przydzialprzedmiotow.php");

    $assignments = $_POST["assignments"];

    $database->query("DELETE FROM przydzialy;");
    // Zastosowanie tego znacząco przyspieszyło działanie skryptu
    $query_string = [];

    foreach($assignments as $grade => $assignment)
        foreach($assignment as $subject => $nothing)
            array_push($query_string, "($grade, $subject)");
    

    $query_string = implode(", ", $query_string);
    $database->query("INSERT INTO przydzialy VALUES $query_string;");       

    redirect("przydzialprzedmiotow.php");
?>