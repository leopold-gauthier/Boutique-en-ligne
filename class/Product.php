<?php
require_once("./include/bdd.php");

class Product
{
    public $id;
    public $id_subcategory;
    public $product;
    public $description;
    public $quantity;
    public $date;
    public $price;
    public $marque;
    //CONSTRUCTOR

    public function __construct($id, $id_subcategory, $product, $description, $quantity, $price, $date, $marque)
    {
        $this->id = $id;
        $this->id_subcategory = $id_subcategory;
        $this->product = $product;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->date = $date;
        $this->marque = $marque;
    }

    public function register($bdd)
    {
        $quantity = $this->quantity;
        $subcategory = $this->id_subcategory;
        $name = $this->product;
        $desc = $this->description;
        $quantity = $this->quantity;
        $date = $this->date;
        $price = $this->price;
        $marque = $this->marque;

        // Chemin du dossier de destination
        $targetDirectory = './product_image/';

        // Tableau pour stocker les nouveaux chemins d'accès des images
        $imagePaths = [];

        // Vérifier si des fichiers ont été téléchargés
        if (!empty($_FILES['image']['name'])) {
            // Boucler à travers tous les fichiers téléchargés
            foreach ($_FILES['image']['name'] as $key => $fileName) {
                // Chemin complet du fichier de destination
                $targetFilePath = $targetDirectory . $fileName;

                // Générer un nouveau nom de fichier unique
                $newFileName = uniqid() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                $targetFilePath = $targetDirectory . $newFileName;

                // Déplacer le fichier téléchargé vers le dossier de destination
                if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetFilePath)) {
                    // Le fichier a été déplacé avec succès, ajouter le chemin d'accès à notre tableau
                    $imagePaths[] = $targetFilePath;
                }
            }
        }

        // Connexion à la base de données (supposons que vous avez déjà une connexion à $bdd)

        $requete = $bdd->prepare("INSERT INTO `product` (`product`, `description`, `quantity`, `price`, date_add, `id_subcategory`, marque) VALUES (?, ?, ?, ?, ?, ?, ?);");
        $requete->execute([$name, $desc, $quantity, $price, $date, $subcategory, $marque]);

        // Récupérer l'ID du dernier enregistrement inséré
        $lastInsertedId = $bdd->lastInsertId();

        // Insérer les chemins d'accès des images dans la table product_image_path
        if (!empty($imagePaths)) {
            $imageInsertQuery = "INSERT INTO `product_image_path` (`id_product`, `path`) VALUES ";
            $imageValues = [];

            foreach ($imagePaths as $path) {
                $imageInsertQuery .= "(?, ?),";
                $imageValues[] = $lastInsertedId;
                $imageValues[] = $path;
            }

            $imageInsertQuery = rtrim($imageInsertQuery, ',');
            $imageInsertStmt = $bdd->prepare($imageInsertQuery);
            $imageInsertStmt->execute($imageValues);
        }

        // Faites d'autres actions si nécessaire après l'insertion en base de données
    }




    public function delete($bdd)
    {
        // Récupérer les chemins des images associées au produit
        $imagePathsQuery = $bdd->prepare("SELECT `path` FROM product_image_path WHERE `id_product` = ?");
        $imagePathsQuery->execute([$this->id]);
        $imagePaths = $imagePathsQuery->fetchAll(PDO::FETCH_COLUMN);

        // Supprimer le produit dans la base de données
        $deleteProductQuery = $bdd->prepare("DELETE FROM product WHERE `id` = ?");
        $deleteProductQuery->execute([$this->id]);
        // Supprimer les enregistrements de la table product_image_path
        $deleteImagePathQuery = $bdd->prepare("DELETE FROM product_image_path WHERE `id_product` = ?");
        $deleteImagePathQuery->execute([$this->id]);


        // Supprimer les images du dossier si elles existent
        foreach ($imagePaths as $imagePath) {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }



    public function update($bdd)
    {
        $update = $bdd->prepare("UPDATE product SET product = ? , quantity = ? , price = ? , gender = ? , type = ? , path = ? WHERE product.id = ?");
        $update->execute([$this->product, $this->quantity, $this->price, $this->id]);
    }
}

// $product = new Product(45, "", "", "", "Homme", "t-shirt", "ici");
// $product->register($bdd);
// $product->delete($bdd);
// $product->update($bdd);
