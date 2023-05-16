<?php ?>
<nav id="nav" class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./serie.php">Hommes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./film.php">Femmes</a>
                </li>
                <?php if (!empty($_SESSION)) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./favoris.php">Favoris</a>
                    </li>
                <?php
                } ?>

            </ul>

        </div>
        <div class="d-flex">
            <input class="form-control me-2" id="search-bar" type="search" placeholder="rechercher..." aria-label="Search">
            <div id="result"></div>
        </div>
        <div class="justify-content-center collapse navbar-collapse">
            <p class="navbar-nav">LASAPPE

            </p>
        </div>


        <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?connect">Compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?signup">Panier</a>
                </li>
            </ul>
        </div>
        <!--         
            <div class="justify-content-end collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./deconnexion.php">Déconnexion</a>
                    </li>
                </ul>
            </div> -->
    </div>
</nav>