<?php
require_once('../includes/functions.php');
$h1 = "Gestion des Commandes - Digimazone";
$boostrapHeader = '';
$boostrapFooter = '';
$scriptForm = '';
require_once('../includes/header.php');
?>
<h1>
    <i class="fas fa-tachometer-alt"></i>
    <?php echo $h1; ?>
</h1>
<section class="sectionSiteLinks">
    <section class="breadcrumb">
        <div class="box-breadcrumb">
            <a class="crumb" href="<?= RACINE_SITE ?>admin/dashboard.php">Dashboard</a>
            <p>/</p>
            <p><?= $h1 ?></p>
        </div>
    </section>
</section>

<?php
require_once('../includes/footer.php');
?>