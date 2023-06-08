<?php
ob_start();
include_once("./include/bdd.php");
include_once("./class/User.php");



$product = $bdd->prepare("SELECT product.id AS id_product, product.*, subcategory.*, 
        GROUP_CONCAT(product_image_path.path) AS image_paths
        FROM product
        INNER JOIN subcategory ON product.id_subcategory = subcategory.id
        INNER JOIN category ON subcategory.id_category = category.id
        INNER JOIN product_image_path ON product.id = product_image_path.id_product
        WHERE product.id = ?
        GROUP BY product.id;");
$product->execute([$_GET['id']]);
$resultproduct = $product->fetch(PDO::FETCH_ASSOC);


$imagePaths = explode(',', $resultproduct['image_paths']);
// Parcourir les chemins d'accès des images
// Ajouter dans le panier
if (isset($_POST['addcart'])) {
    $redirection = $_GET['id'];
    $produit = htmlspecialchars($_POST['addcart']);
    $user = $_SESSION['user']->id;

    $recupUser = $bdd->prepare("SELECT * FROM cart WHERE id_user = ? AND id_product = ?");
    $recupUser->execute([$user, $produit]);

    if ($recupUser->rowCount() > 0) {
        $cartItem = $recupUser->fetch();
        $quantity = $cartItem['quantity'] + 1;

        $addcart = $bdd->prepare("UPDATE cart SET quantity = ? WHERE id_user = ? AND id_product = ?");
        $addcart->execute([$quantity, $user, $produit]);
        header("Location: ./details.php?id=$redirection");
    } else {
        $addcart = $bdd->prepare("INSERT INTO cart (id_user, id_product, quantity) VALUES (?, ?, ?)");
        $addcart->execute([$user, $produit, 1]);
        header("Location: ./details.php?id=$redirection");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <?php include_once("./include/head_inc.php") ?>
    <title>Infos</title>
</head>

<body>
    <header>
        <?php include_once("./include/nav_inc.php") ?>
    </header>
    <main>
        <!-- Modal -->
        <div class="modal" id="imageModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="chemin/vers/mon/image.jpg" alt="Image" class="zoomable-image" id="modalImage">
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTAINER -->
        <div class="container">

            <div id="details">
                <div id="firstpart">
                    <div id="image">
                        <?php
                        // Génération des images
                        foreach ($imagePaths as $index => $imagePath) { ?>
                            <img class="image" src="<?= $imagePath ?>" data-target="#modal<?= $index ?>" />

                            <!-- Modal correspondante à l'image -->
                            <div id="modal<?= $index ?>" class="modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="<?= $imagePath ?>" class="modal-image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="description">
                        <div id="nom">
                            <p><?= $resultproduct['product'] ?></p>
                        </div>
                        <div id="descriptif">
                            <p><?= $resultproduct['description'] ?></p>
                        </div>
                    </div>
                </div>
                <div id="secondpart">
                    <div id="more">
                        <div id="infos">
                            <table class="my-table">
                                <thead>
                                    <tr>
                                        <th class="table-heading">Marque</th>
                                        <th class="table-heading">Catégorie</th>
                                        <th class="table-heading">Prix</th>
                                        <th class="table-heading">Quantité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $resultproduct['marque'] ?></td>
                                        <td><?= $resultproduct['name'] ?></td>
                                        <td><?= $resultproduct['price'] ?>€</td>
                                        <td><?= $resultproduct['quantity'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="panier">
                            <form method="post">
                                <button value="<?= $_GET['id'] ?>" name="addcart" class="btn border" type="submit"><i class="fa-solid fa-plus"></i> Panier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include_once("./include/footer_inc.php") ?>
    </footer>
    <script>
        // Récupération de toutes les images
        var images = document.querySelectorAll('.image');

        // Ajout d'un gestionnaire d'événements clic à chaque image
        images.forEach(function(image) {
            image.addEventListener('click', function() {
                var targetModalId = this.getAttribute('data-target'); // Récupère l'identifiant de la modal cible
                var targetModal = document.querySelector(targetModalId); // Sélectionne la modal correspondante

                if (targetModal) {
                    targetModal.style.display = 'block'; // Affiche la modal
                }
            });
        });

        // Récupération de toutes les modals
        var modals = document.querySelectorAll('.modal');

        // Ajout d'un gestionnaire d'événements clic à chaque modal
        modals.forEach(function(modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === this || event.target.classList.contains('close')) {
                    this.style.display = 'none'; // Ferme la modal si l'utilisateur clique en dehors ou sur le bouton de fermeture
                }
            });
        });
    </script>
</body>
<!-- class="d-flex flex-column flex-md-row flex-wrap" -->

</html>