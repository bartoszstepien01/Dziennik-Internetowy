<?php
    require_once "sprawdz_nauczyciel.php";
    require_once "config.php";

    $grades = $database->query("SELECT * FROM klasy;");
    $subjects = $database->query("SELECT * FROM przedmioty;");

    $assignments = $database->query("SELECT * FROM przydzialy;");
    $assignments = $assignments->fetch_all(MYSQLI_ASSOC);
    $assignments_array = [];

    foreach($assignments as $assignment)
    {
        if(!array_key_exists($assignment["idklasy"], $assignments_array)) 
            $assignments_array[$assignment["idklasy"]] = [];
        $assignments_array[$assignment["idklasy"]][$assignment["idprzedmiotu"]] = 1;
    }

    function keyExists($key1, $key2)
    {
        global $assignments_array;
        return array_key_exists($key1, $assignments_array) && array_key_exists($key2, $assignments_array[$key1]);
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
    <?php include "components/navbar.php"; ?>
    <main style="margin-left: 300px; transition: width 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms,margin 225ms cubic-bezier(0.4, 0, 0.6, 1) 0ms;">
        <div class="container">
            <h3>Przydział przedmiotów</h3>
            <div class="card" style="padding: 1rem;">
                <form action="edytujprzydzialy.php" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Przedmiot</th>
                                <?php while($grade = $grades->fetch_assoc()): ?>
                                    <th><?= $grade["nazwa"] ?></th>
                                <?php endwhile; ?>
                                <?php $grades->data_seek(0); ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($subject = $subjects->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $subject["nazwa"] ?></td>
                                    <?php while($grade = $grades->fetch_assoc()): ?>
                                        <td>
                                            <label>
                                                <input type="checkbox" class="filled-in" <?php if(keyExists($grade["idklasy"], $subject["idprzedmioty"])) echo 'checked="checked"'; ?> name="assignments[<?= $grade["idklasy"] ?>][<?= $subject["idprzedmioty"] ?>]"/>
                                                <span></span>
                                            </label>
                                        </td>
                                    <?php endwhile; ?>
                                    <?php $grades->data_seek(0); ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <br>
                    <button class="btn waves-effect waves-light" type="submit">Dalej</button>
                </form>
            </div>
            <br>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>