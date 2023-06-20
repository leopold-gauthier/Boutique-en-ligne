<?php
ob_start();
include_once("./class/User.php");
// Vérifiez si l'utilisateur est connecté et que ses informations sont présentes dans $_SESSION
if (isset($_SESSION['user'])) {
    // Initialiser l'objet User avec les valeurs récupérées
    $user = new User($_SESSION['user']->id, $_SESSION['user']->login, "", $_SESSION['user']->email, $_SESSION['user']->firstname, $_SESSION['user']->lastname, $_SESSION['user']->tel);
    // Requete pour récupérer les commande celon l'id user
    $reqOrders = $bdd->prepare("SELECT * FROM orders INNER JOIN orders_product ON orders.id = orders_product.id_order WHERE id_user = ? GROUP BY orderID ORDER BY date desc");
    $reqOrders->execute([$user->id]);
    $OrdersUser = $reqOrders->fetchAll(PDO::FETCH_ASSOC);
} else {
    // L'utilisateur n'est pas connecté ou ses informations ne sont pas disponibles
    // Gérer cette situation en conséquence (redirection, affichage d'un message d'erreur, etc.)
    header("Location: ./index.php");
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
    <title>Profil</title>
</head>

<body>
    <header>
        <?php include_once('./include/nav_inc.php') ?>
    </header>
    <main>
        <div class="container">
            <h3>Profil</h3>
            <div class="profil_form">
                <form>
                    <fieldset disabled>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Nom :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?= $user->getLastname(); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Prénom :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?= $user->getFirstname(); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Email :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?= $user->getEmail(); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Téléphone :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?= $user->getTel() ?>">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Rue :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php
                                                                                                        if ($user->findAddress($bdd) == true) {
                                                                                                            if ($user->principalResidence($bdd) == true) {
                                                                                                                $resultPR = $user->getAddressPrincipal($bdd);
                                                                                                                echo $resultPR['street'];
                                                                                                            } else {
                                                                                                                echo "Aucune adresse principal trouvé";
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo "Aucune Adresse Trouvé";
                                                                                                        }
                                                                                                        ?>">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Ville :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php
                                                                                                        if ($user->findAddress($bdd) == true) {
                                                                                                            if ($user->principalResidence($bdd) == true) {
                                                                                                                $resultPR = $user->getAddressPrincipal($bdd);
                                                                                                                echo $resultPR['city'];
                                                                                                            } else {
                                                                                                                echo "Aucune adresse principal trouvé";
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo "Aucune Adresse Trouvé";
                                                                                                        }
                                                                                                        ?>">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Code postal :</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php
                                                                                                        if ($user->findAddress($bdd) == true) {
                                                                                                            if ($user->principalResidence($bdd) == true) {
                                                                                                                $resultPR = $user->getAddressPrincipal($bdd);
                                                                                                                echo $resultPR['postal_code'];
                                                                                                            } else {
                                                                                                                echo "Aucune adresse principal trouvé";
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo "Aucune Adresse Trouvé";
                                                                                                        }
                                                                                                        ?>">
                        </div>
                    </fieldset>
                    <a href="./edit.php"><button type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>Modifier votre profil</button></a>
                </form>
            </div>
            <h3>Commandes</h3>
            <div id="orders">
                <table class="my-table">
                    <thead>
                        <tr>
                            <th class="table-heading">OrderID</th>
                            <th class="table-heading">Payée par</th>
                            <th class="table-heading">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($OrdersUser as $result => $value) {
                        ?>
                            <tr>
                                <td><?= $value['orderID'] ?></td>
                                <td><?= $value['payementSource'] ?></td>
                                <td><?= $value['date'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <?php include_once('./include/footer_inc.php') ?>
    </footer>
</body>

</html>