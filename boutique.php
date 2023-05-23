<?php
ob_start();
include_once('./class/User.php');


// REQUETE --

// fetch product
if (isset($_GET['type'])) {
    $product = $bdd->prepare("SELECT product.*, category.*, subcategory.*
FROM product
INNER JOIN subcategory ON product.id_subcategory = subcategory.id
INNER JOIN category ON subcategory.id_category = category.id WHERE id_category = ?;
");
    $product->execute([$_GET['type']]);
    $resultproduct = $product->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: ./index.php");
}



// fetch man
$man = $bdd->prepare("SELECT * FROM subcategory WHERE id_category = 1");
$man->execute([]);
$resultman = $man->fetchAll(PDO::FETCH_ASSOC);

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
        Boutique
    </title>
</head>

<body>
    <header>
        <?php include_once('./include/nav_inc.php'); ?>
    </header>
    <main>
        <!------ HOMME ------>
        <?php
        if ($_GET['type'] == 1) { ?>
            <div id="container">

                <div id="man">
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
                <div class="produit">
                    <?php
                    foreach ($resultproduct as $result => $value) {
                        var_dump($value) ?>
                        <div class="card" style="width: 18rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">An item</li>
                                <li class="list-group-item">A second item</li>
                                <li class="list-group-item">A third item</li>
                            </ul>
                            <div class="card-body">
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>




            </div>
            <!------- FEMME ------->
        <?php
        } else if ($_GET['type'] == 2) { ?>
            <div id="container">

                <div id="woman">
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
        } else if (isset($_GET[''])) {
            header("Location: ./index.php");
        } ?>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>

</body>

</html>