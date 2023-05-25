<?php
header('Content-Type: application/json');
include_once('./include/bdd.php');


try {
    // Requête pour récupérer toutes les informations de la table "product"
    $sql = "SELECT * FROM product";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();

    // Créer un tableau pour stocker toutes les informations des produits
    $produits = array();

    // Parcourir les résultats de la requête et stocker les informations dans le tableau
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $produits[] = $row;
    }

    // Fermer la connexion à la base de données
    $bdd = null;

    // Renvoyer les données en tant que réponse JSON
    echo json_encode($produits);
} catch (PDOException $e) {
    die("Erreur lors de la connexion à la base de données : " . $e->getMessage());
}
