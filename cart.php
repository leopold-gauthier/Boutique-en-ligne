<?php
ob_start();
include_once('./class/User.php');
if (isset($_SESSION['user'])) {
    // Initialiser l'objet User avec les valeurs récupérées
    $user = new User($_SESSION['user']->id, $_SESSION['user']->login, "", $_SESSION['user']->email, $_SESSION['user']->firstname, $_SESSION['user']->lastname, $_SESSION['user']->tel);

    // si la session est active et que l'user est instancier alors place au produit
    $cartInfo = $bdd->prepare("SELECT  * , cart.quantity as cart_quantity, cart.id as id_cart FROM cart 
    INNER JOIN product ON cart.id_product = product.id 
    WHERE cart.id_user = ?");
    $cartInfo->execute([$_SESSION['user']->id]);
    $resultsCart = $cartInfo->fetchAll(PDO::FETCH_ASSOC);
} else {
    // L'utilisateur n'est pas connecté ou ses informations ne sont pas disponibles
    // Gérer cette situation en conséquence (redirection, affichage d'un message d'erreur, etc.)
    header("Location: ./index.php");
}
if (isset($_POST['deletecart'])) {
    $cartdelete = $bdd->prepare("DELETE FROM `cart` WHERE `cart`.`id` = ?;");
    $cartdelete->execute([$_POST['deletecart']]);
    header("Location: ./cart.php");
}
if (isset($_POST['deleteaddress'])) {
    $user->deleteAddress($bdd);
    header("Location: ./cart.php");
}
if (isset($_POST['addaddress'])) {
    $user->registerAddress($bdd);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/cart.js"></script>
    <?php
    include_once('./include/head_inc.php');
    ?>
    <link rel="stylesheet" href="./style/style.css">
    <title>Panier</title>
</head>

<body>
    <header>
        <?php include_once('./include/nav_inc.php'); ?>
    </header>
    <main>
        <div class="container">
            <h3>Panier</h3>
            <div class="cart">
                <div class="cart_recap">
                    <h5>Articles :</h5>
                    <div class="product_number">
                        <table id="table" class="my-table">
                            <thead>
                                <tr>
                                    <td>Vous avez (<?php if (empty($totalQuantity)) {
                                                        echo 0;
                                                    } else {
                                                        echo $totalQuantity;
                                                    } ?>) articles
                                    <td></td>
                                    <td></td>
                                    <td>Quantité</td>
                                    <td>Prix(€)</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $totalPanier = 0;
                                foreach ($resultsCart as $result => $value) {
                                    $quantite = intval($value['cart_quantity']);
                                    $prix = floatval($value['price']);
                                    $montant = $quantite * $prix;
                                    $totalPanier += $montant;
                                ?>
                                    <tr>
                                        <td><img height="100px" src="<?= $value['path'] ?>" /></td>
                                        <td><?= $value['product'] ?></td>
                                        <td><?= $value['description'] ?></td>
                                        <td><?= $value['cart_quantity'] ?></td>
                                        <td><?= $value['price'] * $value['cart_quantity'] ?>€</td>
                                        <td>
                                            <form method="POST">
                                                <button class="btn btn-secondary" type="submit" value="<?= $value['id_cart'] ?>" name="deletecart"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                }

                                ?>
                            </tbody>

                        </table>

                    </div>
                    <h5>Livraison :</h5>
                    <div id="delivery" class="delivery d-flex">
                        <?php
                        // Si une addresse est trouvé
                        if ($user->findAddress($bdd) == true) {
                            // Si la personne a une résidence principal
                            if ($user->principalResidence($bdd) == true) {
                                $resultPR = $user->getAddressPrincipal($bdd);
                        ?>
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h4 class="card-title">Adresse Principal <i class="fa-solid fa-house-lock"></i></h4>
                                        <div class="mb-3">
                                            <h6 class="card-subtitle mb-2 text-body-secondary">Nom : <?= $resultPR['name_address'] ?></h6>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Adresse : </label>
                                            <input class="form-input" id="address" type="text" value="<?= $resultPR['street'] ?> <?= $resultPR['postal_code'] ?>" disabled />

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="city">Ville : </label><br>
                                            <input class="form-input" id="city" type="text" value="<?= $resultPR['city'] ?>" disabled />
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input class="form-check-input" type="radio" name="radio_address" id="radio_addressPR">
                                            <label class="form-check-label" for="radio_addressPR">
                                                Utiliser cet adresse
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <form method="POST">
                                                <button class="btn btn-secondary" type="submit" value="<?= $resultPR['id'] ?>" name="deleteaddress">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            $results = $user->getAddressSecondary($bdd);
                            foreach ($results as $result) {
                            ?>
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h4 class="card-title">Adresse Secondaire <i class="fa-solid fa-house"></i></h4>
                                        <div class="mb-3">
                                            <h6 class="card-subtitle mb-2 text-body-secondary">Nom : <?= $result['name_address'] ?></h6>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Adresse : </label>
                                            <input class="form-input" id="address" type="text" value="<?= $result['street'] ?> <?= $result['postal_code'] ?>" disabled />

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="city">Ville : </label><br>
                                            <input class="form-input" id="city" type="text" value="<?= $result['city'] ?>" disabled />
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input class="form-check-input" type="radio" name="radio_address" id="radio_address<?= $result['id']; ?>">
                                            <label class="form-check-label" for="radio_address<?= $result['id']; ?>">
                                                Utiliser cet adresse
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <form method="POST">
                                                <button class="btn btn-secondary" type="submit" value="<?= $result['id'] ?>" name="deleteaddress">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php

                            }
                        } else {
                            echo "Aucune adresse trouvé veuillez en ajouter une ci-dessous";
                        }
                        ?>
                    </div>
                    <div class="new_address">
                        <h5>Ajouter une addresse de livraison :</h5>
                        <form class="row g-3 needs-validation" method="post">
                            <div class="col-md-6 position-relative">
                                <label for="street" class="form-label">Rue</label>
                                <input type="text" class="form-control" name="street" id="street" placeholder="100 boulevard de la gare.." required>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text" class="form-control" name="city" id="city" required placeholder="Toulon...">
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="(Propriétaire / Nom du batiment / ...)" required>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="zip" class="form-label">Code postal</label>
                                <input type="text" class="form-control" name="zip" id="zip" required placeholder="83000..">
                                <p>(Livraison uniquement en france)</p>
                            </div>
                            <div class="col-md-12 position-relative">
                                <input class="form-check-input" type="checkbox" name="rp" value="1" id="rp">
                                <label class="form-check-label" for="rp">
                                    Résidence Principal
                                </label>
                            </div>
                            <div class="col-12"><button class="btn btn-primary" name="addaddress" type="submit">Ajouter cette addresse</button></div>
                        </form>
                    </div>
                </div>
                <div class="border"></div>
                <div class="cart_recap">
                    <h5>Récapitulatif :</h5>
                    <div class="total_product">
                        <h5>Articles (<?php
                                        if ($totalQuantity == null) {
                                            echo "0";
                                        } else {
                                            echo $totalQuantity;
                                        }
                                        ?>) :
                            <?php
                            echo number_format($totalPanier, 2);
                            ?> €
                        </h5>
                        <h5>
                            <?php
                            $tva = $totalPanier * 0.20;
                            $totalPanierAvecTva = $totalPanier + $tva;
                            ?>
                            (TVA 20%) : <?= number_format($tva, 2); ?> €<br>

                    </div>
                    <hr>
                    <div class="total">
                        <h5>
                            <b>Total :
                                <?= number_format($totalPanierAvecTva, 2); ?>€
                            </b>
                        </h5>
                    </div>
                    <div class="payment"><button class="btn btn-primary" type="submit">Procéder au paiement</button>
                        <p>Paiement en 3x dès 100,
                            00€ d'achat</p>
                        <p>(souscription légale avec paiement légitime)</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer><?php include_once('./include/footer_inc.php') ?></footer>
</body>

</html>