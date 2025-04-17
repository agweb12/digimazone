<?php
require_once('includes/functions.php');
$h1 = "Connexion - Digimazone";
$boostrapHeader = '';
$boostrapFooter = '';
$scriptForm = '<script src="'.RACINE_SITE.'assets/js/form.js"></script>';
$success = false;
$error = false;
$messageErreur = "";
$email = "";

// Si l'utilisateur est déjà connecté, on le redirige soit vers la page d'accueil
// soit vers le tableau de bord admin
if(isset($_SESSION['user'])) {
    if($_SESSION['user']['statut'] === 'admin') {
        header('Location: ' . RACINE_SITE . 'admin/dashboard.php');
        exit();
    } else {
        header('Location: ' . RACINE_SITE . 'index.php');
        exit();
    }
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $motDePasse = isset($_POST['motDePasse']) ? $_POST['motDePasse'] : '';

    // Validation des données
    if (empty($email) || empty($motDePasse)) {
        $error = true;
        $messageErreur = "Veuillez remplir tous les champs.";
    } else {
        // Authentification de l'utilisateur
        $user = authenticateUser($email, $motDePasse);

        if ($user) {
            // Création de la session utilisateur
            $_SESSION['user'] = $user;

            // Initialisation du panier s'il n'existe pas déjà
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = [
                    'produits' => [],
                    'total' => 0,
                    'quantite' => 0
                ];
            }

            // header("Refresh: 3;url=" . RACINE_SITE . "index.php");
            // echo '<meta http-equiv="refresh" content="3;url='.RACINE_SITE.'index.php>';
            // exit();
            if ($_SESSION['user']['statut'] === 'admin') {
                header('Location: ' . RACINE_SITE . 'admin/dashboard.php');
            } else {
                // Redirection vers la page d'accueil
                $success = true;
                echo '<script>setTimeout(function(){ window.location.href = "'.RACINE_SITE.'index.php"; }, 3000);</script>';
            }
        } else {
            $error = true;
            $messageErreur = "Email ou mot de passe incorrect.";
        }
    }
}

require_once('includes/header.php');
?>

<section class="login-section">
    <div class="login-container">
        <div class="login-form-container">
            <h2>Connexion</h2>
            <?php if ($success): ?>
                <div class="alert-success">
                    <p>Votre connexion a réussi ! Vous allez être redirigé  dans 3 secondes</p>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert-danger">
                    <p><?= $messageErreur ?></p>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="motDePasse" class="form-label">Mot de passe *</label>
                    <input type="password" class="form-control" id="motDePasse" name="motDePasse" required>
                </div>
                
                <div class="form-group remember-forgot">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-primary">Se connecter</button>
                </div>
                
                <div class="register-link">
                    <p>Vous n'avez pas de compte ? <a href="<?= RACINE_SITE ?>register.php">S'inscrire</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
require_once('includes/footer.php');
?>