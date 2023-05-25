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
    <title>Edit profil</title>
</head>
<body>
    <header>
        <?php include_once('./include/nav_inc.php') ?>
    </header>
    <main>
        <div class="container">
    <h3>Modifiez votre profil :</h3>
    <div class="edit_form">
                        <form>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Nom :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Prénom :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Email :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Password :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Confirm password :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Téléphone :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Rue :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Ville :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                <label for="TextInput" class="form-label">Code postal :</label>
                                <input type="text" id="TextInput" class="form-control" placeholder="">
                                </div>
                            <a href="./index.php"><button type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>&nbsp;Modifier votre profil</button></a>
                    </form>
                </div>
            </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>
</html>