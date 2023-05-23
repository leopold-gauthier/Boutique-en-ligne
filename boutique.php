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
// fetch category
if (isset($_GET['cat'])) {
    $product = $bdd->prepare("SELECT product.*, category.*, subcategory.*
FROM product
INNER JOIN subcategory ON product.id_subcategory = subcategory.id
INNER JOIN category ON subcategory.id_category = category.id WHERE id_category = ? AND id_subcategory = ?;
");
    $product->execute([$_GET['type'], $_GET['cat']]);
    $resultproduct = $product->fetchAll(PDO::FETCH_ASSOC);
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
                        <a href="./boutique.php?type=1">
                            <div class="btn btn-secondary">
                                Tous
                            </div>
                        </a>
                        <?php foreach ($resultman as $result => $value) {
                        ?>
                            <a href="./boutique.php?type=1&cat=<?= $value["id"]; ?>">
                                <div class="btn btn-secondary"><?= $value["name"]; ?>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-filter"></i>Filtrer</button>
                    <?php
                    include_once('./include/filter_modal-inc.php');
                    ?>
                </div>
                <div class="produit d-inline-flex">
                    <?php
                    foreach ($resultproduct as $result => $value) { ?>
                        <div class="card" style="width: 10vw;">
                            <img src="<?= $value['path'] ?>" style="height: 15vw;" class=" card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $value['product'] ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Prix :&nbsp;
                                    <?= $value['price'] ?>€</li>
                                <li class="list-group-item">Quantité :&nbsp;
                                    <?= $value['quantity'] ?></li>
                            </ul>
                            <div class="card-body">
                                <a href="#" class="card-link">Panier</a>
                                <a href="#" class="card-link">Détails</a>
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
                        <a href="./boutique.php?type=2">
                            <div class="btn btn-secondary">
                                Tous
                            </div>
                        </a>
                        <?php foreach ($resultwoman as $result => $value) {
                        ?>
                            <a href="./boutique.php?type=2&cat=<?= $value["id"]; ?>">
                                <div class="btn btn-secondary"><?= $value["name"]; ?>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-filter"></i>Filtrer</button>
                    <?php
                    include_once('./include/filter_modal-inc.php');
                    ?>


                </div>
                <div class="produit">
                    <?php
                    foreach ($resultproduct as $result => $value) { ?>
                        <div class="card" style="width: 10rem;">
                            <img src="<?= $value['path'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $value['product'] ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Prix :&nbsp;
                                    <?= $value['price'] ?>€</li>
                                <li class="list-group-item">Quantité :&nbsp;
                                    <?= $value['quantity'] ?></li>
                            </ul>
                            <div class="card-body">
                                <a href="#" class="card-link">Panier</a>
                                <a href="#" class="card-link">Détails</a>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>

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