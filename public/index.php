<?php 
    session_start();

    require_once "config.php";

    if($_SESSION["user"])
    {
        if($_SESSION["user"]["uprawnienia"] >= 1) redirect("oceny.php");
        else redirect("ocenyuczen.php");
    }

    if($_SERVER["REQUEST_METHOD"] == POST)
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = $database->query("SELECT * FROM uczniowie WHERE login = '$username' AND password = '$password';");
        $result = $result->fetch_assoc();

        if($result)
        {
            $_SESSION["user"] = $result;
            if($_SESSION["user"]["uprawnienia"] >= 1) redirect("oceny.php");
            else redirect("ocenyuczen.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="pl" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Dziennik internetowy</title>
</head>
<body class="grey lighten-4" style="height: 100%;">
    <div class="container">
        <br>
        <h2>Dziennik internetowy</h2>
        <h5>Bartosz Stępień kl. IIbp</h5>
        <br>
        <div id="login-page" class="row">
            <div class="col s12 z-depth-6 card-panel">
            <form class="login-form" method="post">
                <div class="input-field col s12">
                    <h4>Zaloguj się</h4>
                </div>
                <div class="input-field col s12">
                    <input id="email" type="text" name="username">
                    <label for="email">Login</label>
                </div>
                <div class="input-field col s12">
                    <input id="password" type="password" name="password">
                    <label for="password">Hasło</label>
                </div>
                <div class="input-field col s12">
                    <button class="btn waves-effect waves-light col s12" type="submit">Logowanie</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>