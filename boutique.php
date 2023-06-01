<?php
ob_start();
include_once('./class/User.php');

// REQUETE --

// fetch product
if (isset($_GET['type'])) {
    $product = $bdd->prepare("SELECT product.id as product_id, product.*, category.*, subcategory.id, 
        product_image_path.path
        FROM product
        INNER JOIN subcategory ON product.id_subcategory = subcategory.id
        INNER JOIN category ON subcategory.id_category = category.id
        INNER JOIN (
            SELECT id_product, path
            FROM product_image_path
            GROUP BY id_product
        ) AS product_image_path ON product.id = product_image_path.id_product
        WHERE id_category = ?;");

    $product->execute([$_GET['type']]);
    $resultproduct = $product->fetchAll(PDO::FETCH_ASSOC);
}

// fetch category
if (isset($_GET['cat'])) {
    $product = $bdd->prepare("SELECT product.id as product_id, product.*, category.*, subcategory.*, product_image_path.path
        FROM product
        INNER JOIN subcategory ON product.id_subcategory = subcategory.id
        INNER JOIN category ON subcategory.id_category = category.id
        INNER JOIN (
            SELECT id_product, path
            FROM product_image_path
            GROUP BY id_product
        ) AS product_image_path ON product.id = product_image_path.id_product
        WHERE id_category = ? AND id_subcategory = ?;");

    $product->execute([$_GET['type'], $_GET['cat']]);
    $resultproduct = $product->fetchAll(PDO::FETCH_ASSOC);
}


// Ajouter dans le panier
if (isset($_POST['addcart'])) {
    $redirection = $_GET['type'];
    $produit = htmlspecialchars($_POST['addcart']);
    $user = $_SESSION['user']->id;

    $recupUser = $bdd->prepare("SELECT * FROM cart WHERE id_user = ? AND id_product = ?");
    $recupUser->execute([$user, $produit]);

    if ($recupUser->rowCount() > 0) {
        $cartItem = $recupUser->fetch();
        $quantity = $cartItem['quantity'] + 1;

        $addcart = $bdd->prepare("UPDATE cart SET quantity = ? WHERE id_user = ? AND id_product = ?");
        $addcart->execute([$quantity, $user, $produit]);
        header("Location: ./boutique.php?type=$redirection");
    } else {
        $addcart = $bdd->prepare("INSERT INTO cart (id_user, id_product, quantity) VALUES (?, ?, ?)");
        $addcart->execute([$user, $produit, 1]);
        header("Location: ./boutique.php?type=$redirection");
    }
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
        <div class="container">
            <!------ HOMME ------>
            <?php
            if ($_GET['type'] == 1) { ?>
                <div id="container">
                    <h3>Hommes</h3>
                    <div id="man">
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
                            <button id="filter" type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-filter"></i>Filtrer</button>
                        </div>
                        <?php
                        include_once('./include/filter_modal-inc.php');
                        ?>
                    </div>
                    <div class="produit d-inline-flex">
                        <?php
                        foreach ($resultproduct as $result => $value) { ?>
                            <a href="details.php?id=<?= $value['product_id'] ?>" class="card-link">
                                <div class="card">
                                    <div style='height:300px; background-size: cover; background-repeat:no-repeat; background-image:url("<?= $value['path'] ?>")'>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $value['product'] ?></h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Prix :&nbsp;
                                            <?= $value['price'] ?>€</li>
                                        <li class="list-group-item">Stock /
                                            <?= $value['quantity'] ?></li>
                                    </ul>
                                    <div class="card-body">
                                        <?php
                                        if (!empty($_SESSION)) {
                                        ?>
                                            <form method="post">
                                                <button value="<?= $value['product_id'] ?>" name="addcart" class="btn" type="submit"><i class="fa-solid fa-plus"></i> Panier</button>
                                            </form>
                                        <?php
                                        } else { ?>
                                            <a href="./connexion.php"><button class="btn bg-secondary" type="button"><i class="fa-solid fa-square-arrow-up-right"></i> Login</button></a>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        <?php
                        } ?>
                    </div>




                </div>
                <!------- FEMME ------->
            <?php
            } else if ($_GET['type'] == 2) { ?>
                <div id="container">
                    <h3>Femmes</h3>
                    <div id="woman">
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
                            <button id="filter" type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-filter"></i>Filtrer</button>
                        </div>
                        <?php
                        include_once('./include/filter_modal-inc.php');
                        ?>


                    </div>
                    <div class="d-flex">
                        <?php
                        foreach ($resultproduct as $result => $value) { ?>
                            <a href="details.php?id=<?= $value['product_id'] ?>" class="card-link">
                                <div class="card">
                                    <div style='height:300px;  background-size: cover; background-repeat:no-repeat; background-image:url("<?= $value['path'] ?>")'>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $value['product'] ?></h5>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Prix :&nbsp;
                                            <?= $value['price'] ?>€</li>
                                        <li class="list-group-item">Stock /&nbsp;
                                            <?= $value['quantity'] ?></li>
                                    </ul>
                                    <div class="card-body">
                                        <?php
                                        if (!empty($_SESSION)) {
                                        ?>
                                            <form method="post">
                                                <button value="<?= $value['product_id'] ?>" name="addcart" class="btn" type="submit"><i class="fa-solid fa-plus"></i> Panier</button>
                                            </form>
                                        <?php
                                        } else { ?>
                                            <a href="./connexion.php"><button class="btn bg-secondary" type="button"><i class="fa-solid fa-square-arrow-up-right"></i> Login</button></a>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        <?php
                        } ?>
                    </div>

                </div>
            <?php
            } else if (isset($_GET[''])) {
                header("Location: ./index.php");
            } ?>
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>

</body>

</html>