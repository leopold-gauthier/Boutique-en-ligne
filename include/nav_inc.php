<?php ?>
<nav id="nav" class="navbar navbar-expand-lg bg-body-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="me-3">LASAPPE</div>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./hommes.php">Hommes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./femmes.php">Femmes</a>
                </li>
            </ul>
        </div>
        <div class="d-flex">
            <input class="form-control me-2" id="search-bar" type="search" placeholder="rechercher..." aria-label="Search">
            <div id="result"></div>
        </div>
        <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./profil.php">Compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cart.php">Panier</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<hr>