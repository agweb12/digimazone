<?php
require_once('includes/functions.php');
$h1 = "Catalogue Digimazone";
$bootstrap = "";
require_once('includes/header.php');
?>
<h1>Bienvenue sur DigiMaZone</h1>
<?php 
    if (isset($_SESSION['user'])) {
        echo '<p class="subTitle">Bonjour ' . $_SESSION['user']['prenom'] . '</p>';
    } else {
        echo '<p class="subTitle">La nouvelle plateforme de vente en ligne des objets digitaux dans votre zone</p>';
    }
?>

<article class="grid-hero">
    <div class="box1">
        <h3>supercharged for pros.</h3>
        <h2>iPad S13+ Pro.</h2>
        <p>A partir de 999,00 € ou 41,62 €/mois</p>
        <p>pendant 24 mois(*)</p>
        <button>acheter maintenant</button>
    </div>
    <div class="box2">
        <h3>meilleure vente</h3>
        <h2>Laptop Max</h2>
        <p>A partir de 1699,00€ </p>
        <p>ou 41,62 €/mois</p>
    </div>
    <div class="box3">
        <h3>nouveauté</h3>
        <h2>Acheter Ipad Air</h2>
        <p>A partir de 1699,00 € </p>
        <p>ou 41,62 €/mois</p>
    </div>
    <div class="box4">
        <h3>15% de réduction</h3>
        <h2>SmartWatch 7</h2>
        <p>À partir de 1699,00 €</p>
        <p>ou 41,62 €/mois</p>
    </div>
    <div class="box5">
        <h3>Gravure gratuite</h3>
        <h2>AirPods Max</h2>
        <p>À partir de 1699,00 € </p>
        <p>ou 41,62 €/mois</p>
    </div>
</article>
<section class="totalSection">
    <h2>Tous nos services</h2>
    <div class="banner-grid-services">
        <div class="box-banner1">
            <i class="fa-solid fa-truck-fast"></i>
            <h3>Livraison gratuite</h3>
            <p class="offer">Pour toute commande supérieure à 100 €</p>
        </div>
        <div class="box-banner2">
            <i class="fa-solid fa-gift"></i>
            <h3>Offres surprises quotidiennes</h3>
            <p class="offer">Économisez jusqu'à 25 %</p>
        </div>
        <div class="box-banner3">
            <i class="fa-solid fa-headphones-simple"></i>
            <h3>Assistance 24 h/24 et 7 j/7</h3>
            <p class="offer">Achetez avec un expert</p>
        </div>
        <div class="box-banner4">
            <i class="fa-solid fa-hand-holding-dollar"></i>
            <h3>Abordable Tarifs</h3>
            <p class="offer">Obtenez le prix direct usine</p>
        </div>
        <div class="box-banner5">
            <i class="fa-solid fa-credit-card"></i>
            <h3>Paiements sécurisés</h3>
            <p class="offer">Paiements 100% sécurisés</p>
        </div>
    </div>
    <h2>Toutes nos catégories de produits</h2>
    <div class="banner-categories">
        <div class="box-categorie">
            <h3>Ordinateur & laptop</h3>
            <p class="offer">6 items</p>
            <img src="./assets/img/ordiportable4.jpg" alt="">
        </div>
        <div class="box-categorie2">
            <h3>caméras & vidéos</h3>
            <p class="offer">10 items</p>
            <img src="./assets/img/camera3.jpg" alt="">
        </div>
        <div class="box-categorie3">
            <h3>TV intelligente</h3>
            <p class="offer">12 items</p>
            <img src="./assets/img/televiseur2.jpg" alt="">
        </div>
        <div class="box-categorie4">
            <h3>montre connectée</h3>
            <p class="offer">13 items</p>
            <img src="./assets/img/montre2.jpg" alt="">
        </div>
        <div class="box-categorie5">
            <h3>musique & jeux</h3>
            <p class="offer">4 items</p>
            <img src="./assets/img/console2.jpg" alt="">
        </div>
        <div class="box-categorie6">
            <h3>mobiles & tablets</h3>
            <p class="offer">5 items</p>
            <img src="./assets/img/tablette2.jpg" alt="">
        </div>
        <div class="box-categorie7">
            <h3>Haut-Parleurs</h3>
            <p class="offer">6 items</p>
            <img src="./assets/img/headphone-bluetooth2.jpg" alt="">
        </div>
        <div class="box-categorie8">
            <h3>accessoires</h3>
            <p class="offer">10 items</p>
            <img src="./assets/img/console1.jpg" alt="">
        </div>
        <div class="box-categorie9">
            <h3>portable speakers</h3>
            <p class="offer">8 items</p>
            <img src="./assets/img/headphone-bluetooth.jpg" alt="">
        </div>
        <div class="box-categorie10">
            <h3>home appliances</h3>
            <p class="offer">6 items</p>
            <img src="./assets/img/headphone2.jpg" alt="">
        </div>
    </div>
    <div class="featured-collection">
        <h2>Produits Vedettes</h2>
        <div class="carousel-featured-collection">
            <div class="box-featured-col">
                <img src="./assets/img/ordiportable4.jpg" alt="">
                <i class="fa-regular fa-heart"></i>
                <div class="box-description-col">
                    <h5>PSI</h5>
                    <h4>Ordinateur Portable i159 Port-9D 7flex</h4>
                    <div class="avis-row">
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                    </div>
                    <p class="price">$100.00</p>
                </div>
            </div>
            <div class="box-featured-col">
                <img src="./assets/img/ecouteur4.jpg" alt="">
                <i class="fa-regular fa-heart"></i>
                <div class="box-description-col">
                    <h5>Havelis</h5>
                    <h4>Kids headphone bulk 10 Pack Multi Colored for</h4>
                    <div class="avis-row">
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                    </div>
                    <p class="price">$100.00</p>
                </div>
            </div>
            <div class="box-featured-col">
                <img src="./assets/img/appareilphoto.jpg" alt="">
                <i class="fa-regular fa-heart"></i>
                <div class="box-description-col">
                    <h5>Canon</h5>
                    <h4>Canon EOS 700D + objectif EF-S 18-135 mm IS STM</h4>
                    <div class="avis-row">
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis"></i>
                    </div>
                    <p class="price">$100.00</p>
                </div>
            </div>
            <div class="box-featured-col">
                <img src="./assets/img/tablette.jpg" alt="">
                <i class="fa-regular fa-heart"></i>
                <div class="box-description-col">
                    <h5>Apple</h5>
                    <h4>iPad Air (2013) 128 Go - WiFi + 4G - Gris Sidéra</h4>
                    <div class="avis-row">
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                    </div>
                    <p class="price">$100.00</p>
                </div>
            </div>
            <div class="box-featured-col">
                <img src="./assets/img/montre3.jpg" alt="">
                <i class="fa-regular fa-heart"></i>
                <div class="box-description-col">
                    <h5>Hublot</h5>
                    <h4>Montre Apple Watch SuperSonic DistincT 3 Epinal</h4>
                    <div class="avis-row">
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                    </div>
                    <p class="price">$100.00</p>
                </div>
            </div>
            <div class="box-featured-col">
                <img src="./assets/img/televiseur.jpg" alt="">
                <i class="fa-regular fa-heart"></i>
                <div class="box-description-col">
                    <h5>Asus</h5>
                    <h4>Ecran 9D Led-H459 DV WR7-MegaLight Holographique</h4>
                    <div class="avis-row">
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis" style="color: #FFD43B;"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                        <i class="fa-solid fa-star avis"></i>
                    </div>
                    <p class="price">$100.00</p>
                </div>
            </div>
        </div>
        <div class="box-collection-row">
            <div class="box-collection dark">
                <div class="mini-box">
                    <p>big screen</p>
                    <h4>smart watch series 7</h4>
                    <h6>From $399.80 or $16.62/mo. for 24 mo.*</h6>
                </div>
                <img src="./assets/img/montre2.jpg" alt="">
            </div>
            <div class="box-collection grey">
                <div class="mini-box">
                    <p>studio display</p>
                    <h4>600 nits of brightness.</h4>
                    <h6>27-inch 5K Retina display</h6>
                </div>
                <img src="./assets/img/tablette2.jpg" alt="">
            </div>
            <div class="box-collection">
                <div class="mini-box">
                    <p>smartphones</p>
                    <h4>smartphone 13 pro.</h4>
                    <h6>Now in Green From $999.00 or £41.62/mo. for 24mo. Footnote*</h6>
                </div>
                <img src="./assets/img/telephone4.jpg" alt="">
            </div>
            <div class="box-collection">
                <div class="mini-box">
                    <p>home speakers</p>
                    <h4>room-filling sound.</h4>
                    <h6>From $699 or $ 116.58/mo. for 12 mo.*</h6>
                </div>
                <img src="./assets/img/headphone-bluetooth3.jpg" alt="">
            </div>
        </div>
    </div>
</section>
<?php
require_once('includes/footer.php');
?>