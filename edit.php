<?php
include_once("./class/User.php");
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
    <script src="./js/editprofil.js" defer></script>
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
                <form method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Login :</label>
                        <input type="text" id="login" name="login" class="form-control" placeholder="<?= $_SESSION['user']->login; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nom :</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" placeholder="<?= $_SESSION['user']->lastname; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Prénom :</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" placeholder="<?= $_SESSION['user']->firstname; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email :</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="<?= $_SESSION['user']->email; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Téléphone :</label>
                        <input type="text" id="tel" name="tel" class="form-control" placeholder="<?= $_SESSION['user']->tel; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirm password :</label>
                        <input type="text" id="password_confirm" name="password_confirm" class="form-control" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Pour enregistrer vos changements veuillez saissir votre mot de passe.</label><br>
                        <button type="submit" id="password_confirm" name="submit" class="btn btn-primary"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>&nbsp;Modifier votre profil</button>
                    </div>
                </form>
                <div class="mb-3">
                    <label for="confirm" class="form-label">Editer votre mot de passe</label><br>
                    <a href="./edit_password"><button type="submit" id="confirm" name="submit" class="btn btn-danger"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>&nbsp;Modifier mot de passe</button></a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>

</html>