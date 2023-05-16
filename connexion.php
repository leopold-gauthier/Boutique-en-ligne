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
    <?php include_once("./include/head_inc.php") ?>
    <title>Connexion</title>
</head>

<body>
    <header>
        <?php include_once("./include/nav_inc.php") ?>
    </header>
    <main>
        <form action="" method="post">
            <div class="mb-3">
                <label class="form-label" for="name">Login: </label>
                <input class="form-control" type="text" name="login" id="login" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password: </label>
                <input class="form-control" type="password" name="password" id="password" required>
            </div>
            <div class="mb-3">
                <input class="form-control" type="submit" name="submit" value="Se connecter">
            </div>
        </form>
    </main>

</body>

</html>

<?php


if (isset($_POST['submit'])) {

    $User = new User("", $_POST["login"], $_POST["password"], "", "", "", "");
    $User->connect($bdd);
    header("Location: ./index.php");
}
?>