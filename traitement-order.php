<?php
include_once("./class/User.php");
$contentJson = file_get_contents("php://input");
// Récupére les informations du payement
$_POST = json_decode($contentJson, true);
// $userId = $_SESSION['user']->id;
$userId = 20;

// Effectuer une requête SELECT pour récupérer les données de la table "cart"
$req = $bdd->prepare("SELECT * FROM cart WHERE id_user = ?");
$req->execute([$userId]);
$cartData = $req->fetchAll(PDO::FETCH_ASSOC);

$del = $bdd->prepare("DELETE FROM cart WHERE id_user = ?");
$del->execute([$userId]);

// Insérer les informations dans la table "order"
$insertOrder = $bdd->prepare("INSERT INTO `orders` ( `orderID`, `payerID`, `payementSource`,`id_user` ,`date`) VALUES ( ?, ?, ?,?,?)");
$insertOrder->execute([$_POST['orderID'], $_POST['payerID'], $_POST['paymentSource'], $userId, date("Y-m-d H:i:s")]);

// Selectionne l'id order
$selectOrder = $bdd->prepare("SELECT id FROM orders WHERE id_user = ? ORDER BY id DESC;");
$selectOrder->execute([$userId]);
$orderId = $selectOrder->fetch(PDO::FETCH_ASSOC);

//  Enregistrer les produits en fonction de la commande
//  Parcourir les données récupérées
foreach ($cartData as $row) {
    $productId = $row['id_product'];
    $productQuantity = $row['quantity'];

    $insertOrder = $bdd->prepare("INSERT INTO `orders_product` ( `id_product`, `id_order`, `quantity`) VALUES (?,?,?)");
    $insertOrder->execute([$productId, $orderId['id'], $productQuantity]);
}
