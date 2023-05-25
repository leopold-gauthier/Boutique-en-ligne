<?php
include_once("./class/User.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <?php include_once("./include/head_inc.php") ?>
    <title>Profil</title>
</head>

<body>
    <header>
        <?php include_once('./include/nav_inc.php') ?>
    </header>
    <main>
        <div class="container">
            <?php
            var_dump($_SESSION);
            if ($_SESSION == NULL) { ?>
                <div id="container">
                    <div class="button">
                        <a href="./connexion.php">Se connecté</a>
                    </div>
                    <div class="button">
                        <a href="./inscription.php">Crée compte</a>
                    </div>
                </div>
            <?php
            } else if (isset($_SESSION)) { ?>
                <div id="container">
                    <div class="button">
                        <a href="./deconnexion.php">Se déconnecter</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

</html>