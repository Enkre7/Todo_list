<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icône sympa -->
    <link rel="shortcut icon" href="./src/icon.png" type="image/x-icon">
    <!-- Titre cool -->
    <title>TODO list !</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <h1>TODO list !</h1>
    <form action="" method="post">
        <input type="text" id="task_tittle" name="task_tittle" placeholder="Insérer un titre de tâche">
        <textarea id="task_text" name="task_text" row_to_dels="4" cols="50" placeholder="Insérer du texte"></textarea>
        <input type="submit" value="Nouvelle tâche">
    </form>

</body>
</html>

<h2 class=""></h2>

<?php

    $file = 'task.json';

    // Si le fichier n'existe pas le crée
    if (!file_exists($file)) {
        touch($file);
    }

    // Écrit dans le fichier JSON si requête POST valide
    if (isset($_POST)) {
        if (isset($_POST['task_text']) and isset($_POST['task_tittle']) 
        && !empty($_POST['task_text']) and !empty($_POST['task_tittle'])) {

            $array = array("Titre" => $_POST['task_tittle'], "Text" => $_POST['task_text'], "Date" => date("d/m/Y - H:i:s"));
            file_put_contents($file, json_encode($array).PHP_EOL, FILE_APPEND);
        
        }
    }

    // Ouverture formulaire pour suppression
    echo '<form action="" method="post">';

    // Parcoure et lit le fichier JSON
    $count = 0;
    $file = fopen(__DIR__.'/task.json','r');
    while (!feof($file)){

        $line = fgets($file);
        $obj = json_decode($line);

        // Si le ligne n'est pas vide affiche les tâches avec leur date et le bouton de suppression
        if (!empty($obj)) {          
            
            echo "<h2>Titre: ".$obj->Titre."</h2>";
            echo "<h2>Date: ".$obj->Date."</h2>";
            echo "<p>".$obj->Text."</p>";
            echo '<form action="" method="post">';
            echo '<td><button type="submit" name="delete" value="'.$count.'" />Supprime</button></td>';
            echo '</form>';
            echo "<hr>";
            $count += 1;

        }
    }

    // Si bouton de suppression cliqué supprime la tâche correspondante
    if(isset($_POST['delete']) and is_numeric($_POST['delete']))
    {
        $delete = $_POST['delete'];
        $lines = file('task.json');

        $row_to_del = file_get_contents('task.json');
        $row_to_del = str_replace($lines[$delete], '', $row_to_del);
        file_put_contents('task.json', $row_to_del);

    }

?>