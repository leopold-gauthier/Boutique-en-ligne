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
            <h3>Profil</h3>
                <div class="profil_form">
                        <form>
                            <fieldset disabled>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Nom :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Prénom :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Email :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Téléphone :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Rue :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Ville :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Code postal :</label>
                                <input type="text" id="disabledTextInput" class="form-control" placeholder="">
                                </div>
                            </fieldset>
                            <a href="./edit.php"><button type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>Modifier votre profil</button></a>
                    </form>
                </div>
            <!--                 zone à revoir              -->
            <?php 
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
                    <!--               fin de zone à revoir              -->
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>

</html>