<?php
require_once("./include/bdd.php");

class Product
{
    public $id;
    public $id_subcategory;
    public $product;
    public $description;
    public $quantity;
    public $price;
    public $path;

    //CONSTRUCTOR

    public function __construct($id, $id_subcategory, $product, $description, $quantity, $price, $path)
    {
        $this->id = $id;
        $this->id_subcategory = $id_subcategory;
        $this->product = $product;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->path = $path;
    }

    public function register($bdd)
    {
        $quantity = $this->quantity;
        $subcategory = $this->id_subcategory;
        $name = $this->product;
        $desc = $this->description;
        $quantity = $this->quantity;
        $price = $this->price;

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

    public function delete($bdd)
    {
        // Récupérer le chemin de l'image associée au produit
        $requete = $bdd->prepare("SELECT `path` FROM product WHERE `id` = ?");
        $requete->execute([$this->id]);
        $row = $requete->fetch();
        $imagePath = $row['path'];

        // Supprimer le produit dans la base de données
        $delete = $bdd->prepare("DELETE FROM product WHERE `id` = ?");
        $delete->execute([$this->id]);

        // Supprimer l'image du dossier si elle existe
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }


    public function update($bdd)
    {
        $update = $bdd->prepare("UPDATE product SET product = ? , quantity = ? , price = ? , gender = ? , type = ? , path = ? WHERE product.id = ?");
        $update->execute([$this->product, $this->quantity, $this->price, $this->path, $this->id]);
    }
}

// $product = new Product(45, "", "", "", "Homme", "t-shirt", "ici");
// $product->register($bdd);
// $product->delete($bdd);
// $product->update($bdd);
