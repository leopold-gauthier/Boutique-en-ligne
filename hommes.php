<?php
include_once('./include/nav_inc.php');
include_once('./include/head_inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./style/style.css">
    <title>Hommes</title>
</head>
<body>
    <div id="container">
        <main>
            <div class="manbtn">
                <h3>Hommes</h3>
                <button type="button" class="btn btn-secondary">T-shirt</button>
                <button type="button" class="btn btn-secondary">Pull</button>
                <button type="button" class="btn btn-secondary">Short</button>
                <button type="button" class="btn btn-secondary">Pantalon</button>
                <button type="button" class="btn btn-light"><i class="fa-solid fa-filter"></i>Filtrer</button>
            </div>
            <div class="manpct_t"></div>
            <div class="manpct_b"></div>
        </main>
        <footer>
            <?php include_once('./include/footer_inc.php') ?>
        </footer>
    </div>
</body>
</html>