<?php 
    session_start();
    require_once "config.php";

    if(!isset($_SESSION["user"]) || $_SESSION["user"]["uprawnienia"] < 1) 
        redirect("index.php");
?>