<?php
ob_start();
include_once('./class/User.php');
if (empty($_SESSION)) {
    header("Location: ./index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">;</script>;  
    <script src="./js/cart.js">;</script>;
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
                        <h5>Vous avez (0) articles</h5>
                    </div>
                        <h5>Livraison :</h5>
                    <div class="delivery">
                    </div>
                    <div class="new_address">
                        <h5>Ajouter une addresse de livraison :</h5>
                        <form class="row g-3 needs-validation" novalidate>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltip03" class="form-label">Rue</label>
                                <input type="text" class="form-control" id="validationTooltip02" required>
                                <div class="invalid-tooltip">
                                Please provide a valid street.
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <label for="validationTooltip03" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="validationTooltip03" required>
                                <div class="invalid-tooltip">
                                Please provide a valid city.
                                </div>
                            </div>
                            <div class="col-md-3 position-relative">
                                <label for="validationTooltip05" class="form-label">Code postal</label>
                                <input type="text" class="form-control" id="validationTooltip05" required>
                                <div class="invalid-tooltip">
                                Please provide a valid zip.
                                </div>
                                <p>(Livraison uniquement en france)</p>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Ajouter cette addresse</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="border"></div>
                <div class="cart_recap">
                    <h5>Récapitulatif :</h5>
                    <div class="total_product">
                        <h5>Articles :</h5>
                    </div>
                        <hr>
                        <div class="total">
                            <h5><b>Total :</b></h5>
                        </div>
                        <div class="payment">
                        <button class="btn btn-primary" type="submit">Procéder au paiement</button>
                            <p>Paiement en 3x dès 100,00€ d'achat</p>
                            <p>(souscription légale avec paiement légitime)</p>
                        </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>

</html>