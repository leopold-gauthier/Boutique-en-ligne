<?php
// REQUETE --
// fetch catégorie
$category = $bdd->prepare("SELECT * FROM category");
$category->execute([]);
$resultcategory = $category->fetchAll(PDO::FETCH_ASSOC);

?>
<nav id="nav" class="navbar navbar-expand-lg bg-body-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="logo" class="me-3"><img src="./style/images/logo.png"></div>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
                </li>
                <?php
                foreach ($resultcategory as $result => $value) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./boutique.php?type=<?= $value['id'] ?>"><?= $value['name'] ?></a>
                    </li>
                <?php
                }
                ?>
                <?php if (!empty($_SESSION) && $_SESSION['user']->login == "admin") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin.php">Admin</a>
                    </li>
                <?php
                } ?>

            </ul>

        </div>

        <div class="d-flex">
            <input class="form-control me-2" id="search-bar" type="search" placeholder="rechercher..." aria-label="Search">
            <div id="suggestion-list"></div>
        </div>


        <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./profil.php">Compte</a>
                </li>
                <?php
                if (!empty($_SESSION)) {
                    // fetch cart
                    $cart = $bdd->prepare("SELECT SUM(quantity) AS total_quantity FROM cart WHERE id_user = ?");
                    $cart->execute([$_SESSION['user']->id]);
                    $result = $cart->fetch(PDO::FETCH_ASSOC);
                    $totalQuantity = $result['total_quantity'];
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./cart.php">Panier <?= $totalQuantity; ?></a>
                        <div id="nbcart"></div>
                    </li>
                <?php
                }
                ?>

            </ul>
        </div>
    </div>
</nav>
<hr>