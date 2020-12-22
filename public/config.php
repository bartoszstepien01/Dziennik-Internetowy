<?php 
    $servername = "dziennik-internetowy-mysql";
    $username = "root";
    $password = "test";
    $dbname = "dziennik";
    
    $database = new mysqli($servername, $username, $password, $dbname);

    function redirect($to) {
        header('Location: '.$to);
    }
?>