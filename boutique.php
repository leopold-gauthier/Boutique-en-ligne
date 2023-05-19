<?php
include_once('./class/User.php');


// REQUETE --
// fetch man
$man = $bdd->prepare("SELECT * FROM subcategory WHERE id_category = 1");
$man->execute([]);
$resultman = $man->fetchAll(PDO::FETCH_ASSOC);
if (isset($GET[''])) {
    header("Location: ./index.php");
}
// fetch woman
$woman = $bdd->prepare("SELECT * FROM subcategory WHERE id_category = 2");
$woman->execute([]);
$resultwoman = $woman->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/boutique.js" defer></script>
    <?php
    include_once('./include/head_inc.php');
    ?>
    <link rel="stylesheet" href="./style/style.css">
    <title>
        <?php
        if (isset($_GET['Homme'])) { ?>
            Hommes
        <?php
        } else if (isset($_GET['Femme'])) { ?>
            Femmes
        <?php
        }
        ?>
    </title>
</head>

<body>
    <header>
        <?php include_once('./include/nav_inc.php'); ?>
    </header>
    <main>
        <!------ HOMME ------>
        <?php
        if (isset($_GET['Homme'])) { ?>
            <div id="container">

                <div class="manbtn">
                    <h3>Hommes</h3>
                    <div class="categorie">
                        <?php foreach ($resultman as $result => $value) {
                        ?>
                            <div class="btn btn-secondary"><?= $value["name"]; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-filter"></i>Filtrer</button>
                    <?php
                    include_once('./include/filter_modal-inc.php');
                    ?>
                </div>
                <div class="manpct_t"></div>
                <div class="manpct_b"></div>


            </div>
            <!------- FEMME ------->
        <?php
        } else if (isset($_GET['Femme'])) { ?>
            <div id="container">

                <div class="manbtn">
                    <h3>Femmes</h3>
                    <div class="categorie">
                        <?php foreach ($resultwoman as $result => $value) {
                        ?>
                            <div class="btn btn-secondary"><?= $value["name"]; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-filter"></i>Filtrer</button>
                    <?php
                    include_once('./include/filter_modal-inc.php');
                    ?>


                </div>
                <div class="manpct_t"></div>
                <div class="manpct_b"></div>


            </div>
        <?php
        } else {
            header("Location: ./index.php");
        } ?>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>

</body>

</html>