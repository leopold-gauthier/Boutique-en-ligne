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
                    <a class="nav-link active" aria-current="page" href="./index.php"><i class="fa-solid fa-house" style="color: #000000;"></i>&nbsp;Accueil</a>
                </li>
                <?php
                foreach ($resultcategory as $result => $value) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./boutique.php?type=<?= $value['id'] ?>">
                            <?php
                            if ($value['id'] == '1') {?>
                                <i class="fa-solid fa-mars" style="color: #000000;"></i>
                            <?php    echo $value['name'];
                            ?>
                            <?php
                            } else if ($value['id'] == "2") {?>
                                <i class="fa-solid fa-venus" style="color: #000000;"></i>
                            <?php    echo $value['name'];
                            } ?></a>
                    </li>
                <?php
                }
                ?>
                <?php if (!empty($_SESSION) && $_SESSION['user']->login == "admin") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin.php"><i class="fa-solid fa-user-shield" style="color: #000000;"></i></i>&nbsp;Admin</a>
                    </li>
                <?php
                } ?>

            </ul>

        </div>

        <div class="d-flex">
            <input class="form-control me-2" id="search-bar" type="search" placeholder="rechercher..." aria-label="Search">
            <div id="result"></div>
        </div>
        <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./profil.php"><i class="fa-solid fa-user" style="color: #000000;"></i> &nbsp;Compte</a>
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
                        <a class="nav-link" href="./cart.php"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i>&nbsp;Panier <?= $totalQuantity; ?></a>
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