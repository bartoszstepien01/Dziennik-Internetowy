<?php 
    require_once "config.php";
    session_start();

    unset($_SESSION["user"]);

    redirect("login.php");
?>