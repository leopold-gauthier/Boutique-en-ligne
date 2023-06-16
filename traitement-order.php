<?php
include_once("./class/User.php");
$contentJson = file_get_contents("php://input");
// Récupére les informations du payement
$_POST = json_decode($contentJson, true);
$userId = $_SESSION['user']->id;

// Effectuer une requête SELECT pour récupérer les données de la table "cart"
$req = $bdd->prepare("SELECT * FROM cart WHERE id_user = ?");
$req->execute([$userId]);
$cartData = $req->fetchAll(PDO::FETCH_ASSOC);

$del = $bdd->prepare("DELETE FROM cart WHERE id_user = ?");
$del->execute([$userId]);

// Insérer les informations dans la table "order"
$insertOrder = $bdd->prepare("INSERT INTO `orders` ( `orderID`, `payerID`, `payementSource`,`id_user` ,`date`) VALUES ( ?, ?, ?,?,?)");
$insertOrder->execute([$_POST['orderID'], $_POST['payerID'], $_POST['paymentSource'], $userId, date("Y-m-d H:i:s")]);


// // Parcourir les données récupérées
foreach ($cartData as $row) {
    $productId = $row['id_product'];
    $pruductPrice = $row['price'];
    $productQuantity = $row['quantity'];
}

// Redirection vers une autre page si nécessaire
// Par exemple : header('Location: autre-page.php');
// SELECT o.order_id, o.customer_id, o.order_date, op.product_id, op.quantity
//     FROM order o
//     INNER JOIN order_product op ON o.order_id = op.order_id
