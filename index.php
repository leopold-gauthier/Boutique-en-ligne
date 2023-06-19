<?php
ob_start();
include("./class/User.php");
$req = $bdd->prepare("SELECT product.id as product_id, product.*, category.*, subcategory.id, 
product_image_path.path
FROM product
INNER JOIN subcategory ON product.id_subcategory = subcategory.id
INNER JOIN category ON subcategory.id_category = category.id
INNER JOIN (
    SELECT id_product, path
    FROM product_image_path
    GROUP BY id_product
) AS product_image_path ON product.id = product_image_path.id_product ORDER BY date_add DESC");
$req->execute([]);
$newproduct = $req->fetchAll(PDO::FETCH_ASSOC);

$req2 = $bdd->prepare("SELECT * , COUNT(orders_product.id_product) AS best_nb_product FROM `orders_product` INNER JOIN product_image_path ON orders_product.id_product = product_image_path.id_product GROUP BY orders_product.id_product ORDER BY best_nb_product DESC;");
$req2->execute([]);
$bestseller = $req2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include_once('./include/head_inc.php');
    ?>
    <link rel="stylesheet" href="./style/style.css">
    <title>Accueil</title>
</head>

<body>
    <header>
        <?php
        include_once('./include/nav_inc.php');
        ?>
    </header>
    <main>
        <div class="container>">
            <div id="index">
                <h2 class="m-25">La Sappe 100% partenaire de la terre <i class="fa-solid fa-face-kiss-wink-heart"></i> !</h2>
                <div id="firstpart">
                    <div id="best_sale">
                        <div id="image">
                            <a href="details.php?id=<?= $bestseller['id_product'] ?>">
                                <img src="<?= $bestseller['path'] ?>" class="d-block w-auto" alt="...">
                            </a>
                        </div>
                        <div id="description">
                            <h5>Best Seller</h5>
                            <p>Profitez de cette opportunité unique pour adopter un style éthique sans compromettre votre sens du glamour. Les articles de notre collection Best-Seller sont non seulement conçus pour impressionner, mais aussi pour témoigner de votre engagement envers l'environnement. Chaque pièce a été soigneusement sélectionnée pour sa qualité, son design moderne et sa contribution à la réduction des déchets textiles.</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="secondpart">
                    <div id="new_product">
                        <div id="image">
                            <div id="carouselExample" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php
                                    foreach ($newproduct as $res) { ?>
                                        <div class="carousel-item">
                                            <a href="details.php?id=<?= $res['product_id'] ?>">
                                                <img src="<?= $res['path'] ?>" class="d-block w-auto" alt="...">
                                            </a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div id="description">
                            <h5>Nouveau produits dans notre boutique</h5>
                            <p>Chers fashionistas engagés,

                                Ne manquez pas notre événement exclusif, "Le Rendez-vous Éco-Chic", où nous vous offrons une occasion unique d'adopter la mode responsable sans vous ruiner ! Nous sommes fiers de vous présenter notre nouvelle collection de vêtements 50% recyclés, conçue pour allier style, durabilité et respect de l'environnement.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        let carousel = document.getElementsByClassName("carousel-item");
        console.log(carousel);
        carousel[0].classList.add('active');
    </script>
</body>
<footer>
    <?php include_once('./include/footer_inc.php') ?>
</footer>

</html>