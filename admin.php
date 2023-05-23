<?php
ob_start();
include_once("./class/User.php");
include_once("./class/Product.php");
if ($_SESSION['user']->login != 'admin') {
    header("Location: ./index.php");
}

// REQUETE -
// fetch AllCateory
$allC = $bdd->prepare("SELECT * FROM category");
$allC->execute([]);
$resultCategory = $allC->fetchAll(PDO::FETCH_ASSOC);

//fetch product
$product = $bdd->prepare("SELECT * , product.id
FROM product
INNER JOIN subcategory ON product.id_subcategory = subcategory.id;
");
$product->execute([]);
$resultProduct = $product->fetchAll(PDO::FETCH_ASSOC);

// fetch man
$man = $bdd->prepare("SELECT * FROM subcategory WHERE id_category = 1");
$man->execute([]);
$resultman = $man->fetchAll(PDO::FETCH_ASSOC);

// fetch woman
$woman = $bdd->prepare("SELECT * FROM subcategory WHERE id_category = 2");
$woman->execute([]);
$resultwoman = $woman->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['addcat'])) {
    if (!empty($_POST['genre']) && !empty($_POST['name'])) {
        $requete = $bdd->prepare("INSERT INTO subcategory (id_category , name) VALUES ( ? , ?);");
        $requete->execute([$_POST["genre"], $_POST["name"]]);
        header("Location: ./admin.php");
    }
}
if (isset($_POST['deletecat'])) {
    $requete = $bdd->prepare("DELETE FROM subcategory WHERE id = ?");
    $requete->execute([$_POST['deletecat']]);
    header("Location: ./admin.php");
}


if (isset($_POST['addproduct'])) {
    $Product = new Product(
        "",
        $_POST['subcategory'],
        $_POST['name'],
        $_POST['description'],
        $_POST['quantity'],
        $_POST['price'],
        ""
    );
    $Product->register($bdd);
    header("Location: ./admin.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("./include/head_inc.php"); ?>
    <script src="./js/admin.js" defer></script>
    <link rel="stylesheet" href="./style/style.css">
    <title>Admin</title>
</head>

<body>
    <header>
        <?php
        include_once('./include/nav_inc.php');
        ?>
    </header>
    <div id="container">
        <main>
            <h3>Admin place</h3>
            <hr>
            <div class="admin">
            <h3>Ajouter/Supprimer sous-catégorie</h3>
                <h4>Ajouter sous-catégorie </h4>
                <div class="add">
                    <form action="" method="post" onsubmit="return verifCat()">
                        <label for="man">Homme</label>
                        <input type="radio" value="1" id="man" name="genre">
                        <label for="woman">Femme</label>
                        <input type="radio" value="2" id="woman" name="genre">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name">
                        <button type="submit" id="submit" name="addcat"><i class="fa-solid fa-square-plus"></i></button>
                    </form>
                    <div id="erreurcat"></div>
                </div>
                <div class="view">
                    <div id="v_man">
                    <h4>Supprimer sous-catégorie </h4>
                        <h5>Homme</h5>
                        <?php foreach ($resultman as $result => $value) {
                        ?>
                            <div class="btn btn-secondary"><?= $value["name"]; ?>
                                <button data-bs-toggle="modal" data-bs-target="#modalsecurity" type="button">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalsecurity">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Êtes-vous sur !</h5>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Ajoutez ici les éléments de votre formulaire de filtrage  -->
                                            <p>Voulez vous vraiment supprimer cet sous-catégorie ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post">
                                                <button class="btn btn-secondary" type="submit" value="<?= $value['id'] ?>" name="deletecat" data-bs-dismiss="modal">Confirmer</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="v_woman">
                        <h5>Femme</h5>
                        <?php foreach ($resultwoman as $result => $value) {
                        ?>

                            <div class="btn btn-secondary"><?= $value["name"]; ?>
                                <button data-bs-toggle="modal" data-bs-target="#modalsecurity" type="button">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalsecurity">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Êtes-vous sur !</h5>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Ajoutez ici les éléments de votre formulaire de filtrage -->
                                            <p>Voulez vous vraiment supprimer cet sous-catégorie ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="post">
                                                <button class="btn btn-secondary" type="submit" value="<?= $value['id'] ?>" name="deletecat" data-bs-dismiss="modal">Confirmer</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                    <HR>
                </div>
            </div>
            <!-- PRODUIT -->
            <!-- /////// -->
            <div class="admin mt-3">
                <h3>Ajouter/Supprimer un produit</h3>
                <h4>Ajouter produit</h4>
                <div class="add">
                    <?php
                    if (isset($_POST['category'])) {
                        // fetch  id_category = ? in Subcategory
                        $allSC = $bdd->prepare("SELECT * FROM subcategory WHERE id_category = ?");
                        $allSC->execute([$_POST['category']]);
                        $resultsubcat = $allSC->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <label for=" genre">Genre :</label>
                            <input id="genre" class="form-control" type="text" name="genre" disabled value='<?php
                                                                                                            if ($_POST['category'] == "1") {
                                                                                                                echo "Homme";
                                                                                                            } else if ($_POST['category'] == "2") {
                                                                                                                echo "Femme";
                                                                                                            }

                                                                                                            ?>'>
                            <label for=" subcategory">Sous-catégorie:</label>
                            <select class="form-control" name="subcategory" id="subcategory">
                                <option value=""></option>
                                <?php
                                foreach ($resultsubcat as $result => $value) {
                                ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                            <label for="name">Nom :</label>
                            <input class="form-control" type="text" id="name" name="name">
                            <label for="description">Description :</label>
                            <textarea class="form-control" id="desc" name="description"></textarea>
                            <label for="price">Prix :</label>
                            <input class="form-control" type="number" step="0.01" id="price" name="price">
                            <label for="quantity">Quantité :</label>
                            <input class="form-control" type="number" id="quantity" name="quantity">
                            <label for="image">Images :</label>
                            <input class="form-control" type="file" id="image" name="image">
                            <button class="form-control bg-secondary" type="submit" id="submit" name="addproduct">Ajouter produit &nbsp;<i class="fa-solid fa-square-plus"></i></button>
                            <a href="./admin.php">Annulé</a>
                        </form>

                    <?php

                    } else { ?>

                        <h5>Veuillez choisir un genre avant de pouvoir ajouter un produit :</h5>
                        <form action="" method="post">
                            <label for="categorie">Catégorie :</label>
                            <select name="category" id="categorie">
                                <option value=""></option>
                                <?php
                                foreach ($resultCategory as $result => $value) { ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                <?php }
                                ?>
                            </select>
                            <input type="submit" value="Valider">
                        </form>
                    <?php
                    }
                    ?>
                </div>
                <div class="view">
                    <div class="v_product">
                        <h5>Supprimer un produit :</h5>
                        <table class="my-table">
                            <thead>
                                <tr>
                                    <th class="table-heading">ID</th>
                                    <th class="table-heading">Nom</th>
                                    <th class="table-heading">Sous-Catégorie</th>
                                    <th class="table-heading">Descriptif</th>
                                    <th class="table-heading">Prix</th>
                                    <th class="table-heading">Quantité</th>
                                    <th class="table-heading">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultProduct as $result => $value) { ?>
                                    <tr>
                                        <td><?= $value['id'] ?></td>
                                        <td><?= $value['product'] ?></td>
                                        <td><?= $value['name'] ?></td>
                                        <td><?= $value['description'] ?></td>
                                        <td><?= $value['price'] ?></td>
                                        <td><?= $value['quantity'] ?></td>
                                        <td>
                                            <form method="POST">
                                                <button class="btn btn-secondary" type="submit" value="<?= $value['id'] ?>" name="deleteprod"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                    if (isset($_POST['deleteprod'])) {
                                        $product = new Product($_POST['deleteprod'], "", "", "", "", "", "");
                                        $product->delete($bdd);
                                        header("Location: ./admin.php");
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <?php include_once('./include/footer_inc.php') ?>
        </footer>
    </div>
    <?php




    ?>
</body>

</html>