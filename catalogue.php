<?php
require_once('includes/functions.php');
$h1 = "Catalogue Digimazone";
$boostrapHeader = '';
$boostrapFooter = '';
$scriptForm = '';
require_once('includes/header.php');
?>
<section class="sectionCatalogue">
    <section class="breadcrumb">
        <div class="box-breadcrumb">
            <a href="">Accueil</a>
            <p>/</p>
            <a href="">Notre Catalogue de Produit</a>
        </div>
    </section>
    <h2>Produits</h2>
    <section class="categories-collection">
        <aside class="filter-products">
            <h3>Filtre des produits</h3>
            <!-- Disponibilité -->
            <div class="mini-filter">
                <h4>Disponibilité</h4>
                <label><input type="checkbox" name="dispo" value="disponible"> En stock</label>
            </div>

            <!-- Prix -->
            <div class="mini-filter">
                <h4>Prix</h4>
                <div>
                    <button id="minus">-</button>
                    <input type="number" id="prix_min" value="0">
                    <input type="number" id="prix_max" value="1000">
                    <button id="plus">+</button>
                </div>
            </div>

            <!-- Couleur -->
            <div class="mini-filter">
                <h4>Couleurs Catégories</h4>
                <div class="couleurs">
                    <span class="couleur" data-couleur="#FF0000" style="background:#FF0000;"></span>
                    <span class="couleur" data-couleur="#0000FF" style="background:#0000FF;"></span>
                </div>
            </div>

            <!-- Étiquettes -->
            <div class="mini-filter">
                <h4>Etiquettes</h4>
                <div class="etiquettes">
                    <button class="etiquette" data-id="1">Gaming</button>
                    <button class="etiquette" data-id="2">Apple</button>
                </div>
            </div>
        </aside>
        <div class="products-categories-collection">
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
                    <button>Ajouter au panier</button>
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
        </div>
    </section>
</section>
<?php
require_once('includes/footer.php');
?>