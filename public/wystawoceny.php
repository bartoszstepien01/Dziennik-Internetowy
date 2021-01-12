<?php 
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] != "POST")
        redirect("/");
    
    $marks = $_POST["mark"];
    $descs = $_POST["desc"];

    $teacher_id = $_SESSION["user"]["iduczniowie"];

    foreach($marks as $id => $subject)
        foreach($subject as $id2 => $mark)
            if(!empty($mark))
            {
                $temp_desc = $descs[$id][$id2];
                $database->query("INSERT INTO oceny (ocena, iducznia, opis, idprzedmiot, nauczyciel) VALUES ('$mark', $id2, '$temp_desc', $id, $teacher_id);");
            }
    
    redirect("/");
?>