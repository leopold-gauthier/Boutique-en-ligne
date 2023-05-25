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
    <?php
    include_once('./include/head_inc.php');
    ?>
    <link rel="stylesheet" href="./style/style.css">
    <title>Accueil</title>
</head>

<body>
    <header>
        <?php
        include_once('./include/nav_inc.php');
        ?>
    </header>
    <main>
        <div class="best_sale">          
        </div>
        <div class="new_product">
        </div>
        <!-- <?php var_dump($_SESSION); ?> -->
    </main>
</body>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>

</html>