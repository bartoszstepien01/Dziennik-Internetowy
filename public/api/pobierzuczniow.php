<?php 
    require_once "../config.php";

    $grade = $_GET["grade"];
    $array = [];

    $students = $database->query("SELECT iduczniowie, nazwisko, imie FROM uczniowie WHERE idklasy = $grade ORDER BY nazwisko, imie;");
    while($row = $students->fetch_assoc())
        $array[] = $row;

    echo json_encode($array);
?>