<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("konta.php");

    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $type = (int) $_POST["type"];

    if($type == 0) {
        $grade = $_POST["grade"];
        $database->query("INSERT INTO uczniowie(nazwisko, imie, idklasy, login, password, uprawnienia) VALUES ('$surname', '$name', $grade, '$login', '$password', $type);");
    } else
        $database->query("INSERT INTO uczniowie(nazwisko, imie, login, password, uprawnienia) VALUES ('$surname', '$name', '$login', '$password', $type);");
    
    redirect("konta.php");
?>