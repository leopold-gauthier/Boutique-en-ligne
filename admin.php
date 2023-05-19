<?php
include_once("./class/User.php");
if ($_SESSION['user']->login != 'admin') {
    header("Location: ./index.php");
}

// REQUETE -
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
            <h3>Admin</h3>
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
                </div>
            </div>

            <!-- /////// -->
            <div class="admin">
                <h4>Ajouter/Supprimer produit</h4>
                <div class="add">
                    <form action="" method="post">
                        <label for="category">Catégorie:</label>
                        <select name="category" id="category">
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="hamster">Hamster</option>
                            <option value="parrot">Parrot</option>
                            <option value="spider">Spider</option>
                            <option value="goldfish">Goldfish</option>
                        </select>
                        <label for="subcategory">Sous-catégorie:</label>
                        <select name="subcategory" id="subcategory">
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="hamster">Hamster</option>
                            <option value="parrot">Parrot</option>
                            <option value="spider">Spider</option>
                            <option value="goldfish">Goldfish</option>
                        </select>
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name">
                        <label for="price">Prix :</label>
                        <input type="text" id="price" name="price">
                        <button type="submit" id="submit" name="addproduct"><i class="fa-solid fa-square-plus"></i></button>
                    </form>
                </div>
            </div>
        </main>
        <footer>
            <?php include_once('./include/footer_inc.php') ?>
        </footer>
    </div>
</body>

</html>