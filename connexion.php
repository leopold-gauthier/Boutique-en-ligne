<?php
ob_start();
include("./class/User.php");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <script src="./js/connexion.js" defer></script>
    <?php include_once("./include/head_inc.php") ?>
    <title>Connexion</title>
</head>

<body>
    <header>
        <?php include_once("./include/nav_inc.php") ?>
    </header>
    <main>
        <div class="container">
            <form action="" method="post" onsubmit="return validerFormulaire()">
                <div class="mb-3">
                    <label class="form-label" for="name">Login: </label>
                    <input class="form-control" type="text" name="login" id="login">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password: </label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <div class="mb-3">
                    <div id="erreur"></div>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="submit" name="submit" value="Se connecter">
                </div>
            </form>
            <a href="inscription.php">S'inscrire !</a>&nbsp;/&nbsp; Mot de passe oublié ?
        </div>
    </main>

</body>

</html>

<?php
if ($_SESSION != NULL) {
    header("Location: ./profil.php");
}
if (isset($_POST['submit'])) {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $user = new User("", $login, $password, "", "", "", "");

    if ($user->connect($bdd)) {
        header("Location: ./connexion.php");
        exit; // Important pour arrêter l'exécution du script après la redirection
    } else {
        echo '
        <script>
            document.getElementById("erreur").textContent = "Le login ou le mot de passe incorrect.";
        </script>';
    }
}
