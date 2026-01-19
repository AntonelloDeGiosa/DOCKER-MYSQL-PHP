<?php
if ($_COOKIE["theme"] == "dark") {
    echo '<body class="dark-bg">';
} else {
    echo '<body class="white-bg">';
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferenze</title>
    <link rel="stylesheet" href="static/CSS/preferenze.css">

    
</head>
<body class="white-bg">
    <h1>Benvenuto <?php echo $_COOKIE["username"]; ?>   </h1>
    <p>
        tema selezionato : <?php echo $_COOKIE["theme"]; ?>
        
    </p>
</body>
</html>