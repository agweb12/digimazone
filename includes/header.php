<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $h1 ?></title>
    <meta name="description" content="La nouvelle plateforme de vente en ligne des objets digitaux dans votre zone">
    <link rel="stylesheet" href="<?= RACINE_SITE ?>assets/css/style.css">
    <?= $boostrap ?>
    <script src="https://kit.fontawesome.com/b83fa86058.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <ul class="generalInfo">
                <p>Livraison Gratuite à partir de 100€ d'achat et Remboursement Gratuit</p>
                <li>
                    <p class="tel">HotLine 24h/7j : +33 7 89 16 64 85</p>
                    <div class="switching">
                        <div class="buttonSwitch"></div>
                        <i class="fa-regular fa-moon" id="lune"></i>
                        <i class="fa-regular fa-sun" id="soleil"></i>
                    </div>
                </li>
            </ul>
            <ul class="accountResearchLogo">
                <li>
                    <a href="" class="logo">
                        <img src="<?= RACINE_SITE ?>assets/img/logo.svg" alt="logo">
                    </a>
                </li>
                <li>
                    <input type="search" name="" id="" placeholder="Search Product here..." </li>
                <li>
                    <div class="accounting">
                        <a href="<?= RACINE_SITE ?>profil/favoris.php" class="list"><i class="fa-regular fa-heart"></i>Mes Produits<br>Favoris</a>
                        <a href="<?= RACINE_SITE ?>login.php" class="list"><i class="fa-regular fa-user"></i>Se Connecter<br>À Mon Compte</a>
                        <a href="<?= RACINE_SITE ?>boutique/cart.php" class="list panier">
                            <i class="fa-solid fa-cart-shopping" style="color: #FFDE00;"></i>
                            <div class="nbArticle">
                                <p class="nb">0</p>
                                <p>$0.00</p>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
            <ul class="menu">
                <li class="shopCategorie">
                    <div class="box">
                        <i class="fa-solid fa-list"></i>
                        <h3>Catégorie des Produits</h3>
                    </div>
                    <i class="fa-solid fa-chevron-down"></i>
                </li>
                <li>
                    <a href="<?= RACINE_SITE ?>" class="navigation">Accueil</a>
                    <a href="<?= RACINE_SITE ?>catalogue.php" class="navigation">Catalogue des produits</a>
                    <a href="<?= RACINE_SITE ?>profil/orders.php" class="navigation">Mes Commandes</a>
                    <a href="<?= RACINE_SITE ?>profil/account.php" class="navigation">Mon Compte</a>
                    <a href="<?= RACINE_SITE ?>contact.php" class="navigation">Contactez-Nous</a>
                </li>
            </ul>
            <ul class="menuCache">
                <div class="box">
                    <li>
                        <h3>Appareil Photo</h3>
                        <a href="">Camera</a>
                        <a href="">Camera Accessories</a>
                        <a href="">Camera Lenses</a>
                        <a href="">Camera Drone</a>
                        <a href="">Camera Bags</a>
                        <a href="">Camera Batteries</a>
                        <a href="">Camera Flash</a>
                    </li>
                    <li>
                        <h3>Téléphone</h3>
                        <a href="">Smartphones</a>
                        <a href="">Accessoires</a>
                        <a href="">Etuis Smartphone</a>
                        <a href="">Ecran de Protection Smartphone</a>
                        <a href="">Batteries Smartphone</a>
                        <a href="">Chargeurs Smartphone</a>
                    </li>
                </div>
                <div class="box">
                    <li>
                        <h3>Ordinateur</h3>
                        <a href="">Laptop</a>
                        <a href="">Accessoires Laptop</a>
                        <a href="">Sacs Laptop</a>
                        <a href="">Batteries Laptop</a>
                        <a href="">Chargeurs Laptop</a>
                        <a href="">Pochette Laptop</a>
                        <a href="">Support de Refroidissement Laptop</a>
                        <a href="">Station d'Accueil Laptop</a>
                    </li>
                    <li>
                        <h3>Audio</h3>
                        <a href="">Haut-Parleurs</a>
                        <a href="">Écouteurs</a>
                        <a href="">Enceintes Bluetooth</a>
                        <a href="">Barres de son</a>
                        <a href="">Home Cinéma</a>
                        <a href="">Câbles audio</a>
                        <a href="">Accessoires audio</a>
                    </li>
                </div>
                <div class="box">
                    <li>
                        <h3>TV & Vidéo</h3>
                        <a href="">TV</a>
                        <a href="">Accessoires TV</a>
                        <a href="">Supports TV</a>
                        <a href="">Câbles TV</a>
                        <a href="">Télécommande TV</a>
                        <a href="">Haut-parleurs TV</a>
                    </li>
                    <li>
                        <h3>Tablette</h3>
                        <a href="">Tablette</a>
                        <a href="">Accessoires pour Tablette</a>
                        <a href="">Étuis pour Tablette</a>
                        <a href="">Protecteur d'écran pour Tablette</a>
                        <a href="">Batteries pour Tablette</a>
                        <a href="">Chargeurs pour Tablette</a>
                        <a href="">Casques pour Tablette</a>
                    </li>
                </div>
            </ul>
        </nav>
    </header>
    <main>