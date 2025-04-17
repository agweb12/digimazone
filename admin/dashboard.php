<?php
require_once('../includes/functions.php');
$h1 = "Tableau de bord - Digimazone";
$boostrapHeader = '';
$boostrapFooter = '';
$scriptForm = '';
require_once('../includes/header.php');
?>
<h1>
    <i class="fas fa-tachometer-alt"></i>
    <?php echo $h1; ?>
</h1>
<p class="subTitle">Bienvenue sur le tableau de bord</p>

<section class="totalSection">
    <div class="banner-dashboard">
        <a class="box-dashboard" href="<?= RACINE_SITE ?>admin/manageCategories.php">
            <h3>Gérer les Catégories</h3>
            <p class="offer">6 items</p>
        </a>
        <a class="box-dashboard" href="<?= RACINE_SITE ?>admin/manageUtilisateurs.php">
            <h3>Gérer les Utilisateurs</h3>
            <p class="offer">10 items</p>
        </a>
        <a class="box-dashboard" href="<?= RACINE_SITE ?>admin/manageProduits.php">
            <h3>Gérer les Produits</h3>
            <p class="offer">12 items</p>
        </a>
        <a class="box-dashboard" href="<?= RACINE_SITE ?>admin/manageCommandes.php">
            <h3>Gérer les Commandes</h3>
            <p class="offer">13 items</p>
        </a>
        <a class="box-dashboard" href="<?= RACINE_SITE ?>admin/manageEtiquettes.php">
            <h3>Gérer les Etiquettes</h3>
            <p class="offer">4 items</p>
        </a>
    </div>
</section>

<?php
require_once('../includes/footer.php');
?>