<?php
include_once("./class/User.php");

var_dump($_POST);
if (isset($_POST['submit'])) {
    $user = new User($_SESSION['user']->id, $_POST['login'], null, $_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['tel']);
    $user->Update($bdd);
}
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
            <h3>Modifiez mot de passe :</h3>
            <div class="edit_form">
                <form method="post">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe :</label>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirm" class="form-label">Confirmer nouveau mot de passe :</label>
                        <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmer mot de passe actuel :</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="confirm" class="form-label">Pour enregistrer vos changements veuillez saissir votre mot de passe.</label><br>
                        <button type="submit" id="confirm" name="submit" class="btn btn-primary"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>&nbsp;Modifier votre profil</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>

</html>