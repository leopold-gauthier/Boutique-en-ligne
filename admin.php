<?php
include_once('./include/nav_inc.php');
include_once('./include/head_inc.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Admin</title>
</head>

<body>
    <div id="container">
        <main>
            <h3>Admin</h3>
            <div class="admin">
                <h4>Ajouter/Supprimer sous-catégorie</h4>
                <div class="add">
                    <form action="" method="post">
                        <label for="man">Homme</label>
                        <input type="checkbox" id="man" name="man">
                        <label for="woman">Femme</label>
                        <input type="checkbox" id="woman" name="woman">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name">
                        <button type="submit" id="submit" name="addcat"><i class="fa-solid fa-square-plus"></i></button>
                    </form>
                </div>
            </div>
            <div class="admin">
                <h4>Ajouter/Supprimer produit</h4>
                <div class="add">
                    <form action="" method="post">
                        <label for="pet-select">Catégorie:</label>
                        <select name="pets" id="pet-select">
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="hamster">Hamster</option>
                            <option value="parrot">Parrot</option>
                            <option value="spider">Spider</option>
                            <option value="goldfish">Goldfish</option>
                        </select>
                        <label for="pet-select">Sous-catégorie:</label>
                        <select name="pets" id="pet-select">
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
                        <button type="submit" id="submit" name="addcat"><i class="fa-solid fa-square-plus"></i></button>
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