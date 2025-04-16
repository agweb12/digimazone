<?php
require_once('includes/functions.php');
$h1 = "Inscription - Digimazone";
$boostrapHeader = ''; 
$boostrapFooter = '';
$scriptForm = '<script src="'.RACINE_SITE.'assets/js/form.js"></script>';
require_once('includes/header.php');

// Initialisation des variables
$success = false;
$error = false;
$messageErreur = "";
$civilite = "";
$nom = "";
$prenom = "";
$email = "";
$telephone = "";
$dateNaissance = "";
$rue = "";
$ville = "";
$codePostal = "";
$pays = "";

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $civilite = isset($_POST['civilite']) ? $_POST['civilite'] : '';
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $motDePasse = isset($_POST['motDePasse']) ? $_POST['motDePasse'] : '';
    $confirmMotDePasse = isset($_POST['confirmMotDePasse']) ? $_POST['confirmMotDePasse'] : '';
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
    $dateNaissance = isset($_POST['dateNaissance']) ? $_POST['dateNaissance'] : '';
    $rue = isset($_POST['rue']) ? trim($_POST['rue']) : '';
    $ville = isset($_POST['ville']) ? trim($_POST['ville']) : '';
    $codePostal = isset($_POST['codePostal']) ? trim($_POST['codePostal']) : '';
    $pays = isset($_POST['pays']) ? trim($_POST['pays']) : '';

    // Validation des données
    if (empty($civilite) || empty($nom) || empty($prenom) || empty($email) || empty($motDePasse) || 
        empty($confirmMotDePasse) || empty($telephone) || empty($dateNaissance)) {
        $error = true;
        $messageErreur = "Tous les champs marqués d'un * sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $messageErreur = "L'adresse email n'est pas valide.";
    } elseif ($motDePasse !== $confirmMotDePasse) {
        $error = true;
        $messageErreur = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($motDePasse) < 8) {
        $error = true;
        $messageErreur = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif (getUserByEmail($email)) {
        $error = true;
        $messageErreur = "Cette adresse email est déjà utilisée.";
    } else {
        // Création de l'utilisateur
        $userData = [
            'civilite' => $civilite,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'motDePasse' => $motDePasse,
            'telephone' => $telephone,
            'dateNaissance' => $dateNaissance,
            'statut' => 'client'
        ];

        $userId = createUser($userData);

        // Si l'utilisateur a été créé avec succès et qu'une adresse a été saisie
        if ($userId && !empty($rue) && !empty($ville) && !empty($codePostal) && !empty($pays)) {
            $adresseData = [
                'rue' => $rue,
                'ville' => $ville,
                'codePostal' => $codePostal,
                'pays' => $pays
            ];
            
            // Ajout de l'adresse
            addUserAddress($userId, $adresseData);
        }

        if ($userId) {
            $success = true;
            // Redirection vers la page de connexion après 3 secondes
            header("refresh:3;url=" . RACINE_SITE . "login.php");
        } else {
            $error = true;
            $messageErreur = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<section class="register-section">
    <div class="register-container">
        <div class="register-form-container">
            <h2>Créer un compte</h2>
            
            <?php if ($success): ?>
                <div class="alert-success">
                    <p>Votre compte a été créé avec succès ! Vous allez être redirigé vers la page de connexion...</p>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert-danger">
                    <p><?= $messageErreur ?></p>
                </div>
            <?php endif; ?>

            <?php if (!$success): ?>
            <form method="POST" action="" class="register-form">
                <div class="form-columns">
                    <div class="form-column">
                        <h3>Informations personnelles</h3>
                        
                        <div class="form-group">
                            <label class="form-label">Civilité *</label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" name="civilite" id="civiliteM" value="M" <?= $civilite === 'M' ? 'checked' : '' ?>>
                                    <label for="civiliteM">M.</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="civilite" id="civiliteMme" value="Mme" <?= $civilite === 'Mme' ? 'checked' : '' ?>>
                                    <label for="civiliteMme">Mme</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom" class="form-label">Prénom *</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone" class="form-label">Téléphone *</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($telephone) ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="dateNaissance" class="form-label">Date de naissance *</label>
                            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="<?= htmlspecialchars($dateNaissance) ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="motDePasse" class="form-label">Mot de passe *</label>
                            <input type="password" class="form-control" id="motDePasse" name="motDePasse">
                            <div class="form-text">Le mot de passe doit contenir au moins 8 caractères.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirmMotDePasse" class="form-label">Confirmer le mot de passe *</label>
                            <input type="password" class="form-control" id="confirmMotDePasse" name="confirmMotDePasse">
                        </div>

                        <div class="form-group checkbox-group">
                            <input type="checkbox" class="form-check-input" id="conditions" name="conditions">
                            <label class="form-check-label" for="conditions">J'accepte les conditions générales d'utilisation *</label>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn-primary">S'inscrire</button>
                        </div>
                        
                        <div class="login-link">
                            <p>Vous avez déjà un compte ? <a href="<?= RACINE_SITE ?>login.php">Se connecter</a></p>
                        </div>
                    </div>
                        
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php
require_once('includes/footer.php');
?>