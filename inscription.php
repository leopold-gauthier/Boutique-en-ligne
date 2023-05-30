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
    <script src="./js/inscription.js" defer></script>
    <?php include_once("./include/head_inc.php") ?>
    <title>Inscription</title>
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
                    <label class="form-label" for="email">Email: </label>
                    <input class="form-control" type="email" name="email" id="email">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="firstname">Firstname: </label>
                    <input class="form-control" type="text" name="firstname" id="firstname">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="lastname">Lastname: </label>
                    <input class="form-control" type="text" name="lastname" id="lastname">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lastname">Tél: </label>
                    <input class="form-control" type="tel" name="tel" id="tel">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password: </label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password Confirm: </label>
                    <input class="form-control" type="password" name="password_confirm" id="password_confirm">
                </div>
                <div class="mb-3">
                    <div id="erreur"></div>
                </div>
                <div class="mb-3">
                    <input class="form-control" class="button" type="submit" name="submit" value="S'inscrire">
                </div>
            </form>
        </div>

    </main>
</body>

</html>


<?php
if (isset($_POST['submit'])) {
    $user = new User(NULL, htmlspecialchars($_POST["login"]), $_POST["password"], htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["firstname"]), htmlspecialchars($_POST["lastname"]), htmlspecialchars($_POST["tel"]));
    $user->register($bdd);
    header('Location: ./index.php');
}
?>