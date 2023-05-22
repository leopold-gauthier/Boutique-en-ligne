<?php
include_once("./class/User.php");
if ($_SESSION['user']->login != 'admin') {
    header("Location: ./index.php");
}

// REQUETE -
// fetch AllCateory
$allC = $bdd->prepare("SELECT * FROM category");
$allC->execute([]);
$resultCategory = $allC->fetchAll(PDO::FETCH_ASSOC);

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
                <h4>Ajouter/Supprimer sous-catégorie</h4>
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
                <h4>Ajouter/Supprimer produit</h4>
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
                            <button class="form-control bg-secondary" type="submit" id="submit" name="addproduct"><i class="fa-solid fa-square-plus"></i></button>
                            <a href="./admin.php">Annulé</a>
                        </form>

                    <?php

                    } else { ?>

                        <h5>Veuillez choisir un genre avant de pouvoir ajouter un produit</h5>
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
            </div>
        </main>
        <footer>
            <?php include_once('./include/footer_inc.php') ?>
        </footer>
    </div>
    <?php
    if (isset($_POST['addproduct'])) {
        $quantity = $_POST['quantity'];
        $subcategory = $_POST['subcategory'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price = $_POST['price'];

        // Chemin du dossier de destination
        $targetDirectory = './product_image/';

        // Nom du fichier
        $fileName = $_FILES['image']['name'];
        // Chemin complet du fichier de destination
        $targetFilePath = $targetDirectory . $fileName;

        // Déplacer le fichier téléchargé vers le dossier de destination
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Le fichier a été déplacé avec succès, effectuer l'insertion en base de données

            // Connexion à la base de données (supposons que vous avez déjà une connexion à $bdd)

            $requete = $bdd->prepare("INSERT INTO `product` (`product`, `description`, `quantity`, `price`,`path`, `id_subcategory`) VALUES (?, ?, ?, ?, ?, ?);");
            $requete->execute([$name, $desc, $quantity, $price, $targetFilePath, $subcategory]);

            // Récupérer l'ID du dernier enregistrement inséré
            $lastInsertedId = $bdd->lastInsertId();

            // Nouveau nom de fichier avec l'ID du produit
            $newFileName = $lastInsertedId . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $newFilePath = $targetDirectory . $newFileName;
            // Renommer le fichier avec l'ID du produit
            if (rename($targetFilePath, $newFilePath)) {
                // Mettre à jour l'enregistrement avec le nouveau chemin de l'image associé
                $updateRequete = $bdd->prepare("UPDATE `product` SET `path` = ? WHERE `id` = ?");
                $updateRequete->execute([$newFilePath, $lastInsertedId]);

                // Faites d'autres actions si nécessaire après l'insertion en base de données

            } else {
            }
        } else {
        }
    }




    ?>
</body>

</html>