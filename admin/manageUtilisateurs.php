<?php
require_once('../includes/functions.php');
$h1 = "Gestion des utilisateurs - Digimazone";
$boostrapHeader = '';
$boostrapFooter = '';
$scriptForm = '<script src="'.RACINE_SITE.'assets/js/form.js"></script>';

// Vérification des droits d'accès (page réservée aux administrateurs)
if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] !== 'admin') {
    header('Location: ' . RACINE_SITE . 'index.php');
    exit();
}

// Initialisation des variables
$message = "";
$messageType = "";
$utilisateurs = getAllUsers(); // Récupération de tous les utilisateurs
$utilisateurEdit = null; // Utilisateur en cours d'édition

// Traitement de la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idUtilisateur = (int)$_GET['id'];
    
    // Vérifier que l'utilisateur n'est pas en train de se supprimer lui-même
    if ($idUtilisateur === (int)$_SESSION['user']['id']) {
        $message = "Vous ne pouvez pas supprimer votre propre compte.";
        $messageType = "error";
    } else {
        if (deleteUser($idUtilisateur)) {
            $message = "Utilisateur supprimé avec succès.";
            $messageType = "success";
            $utilisateurs = getAllUsers(); // Rafraîchir la liste
        } else {
            $message = "Erreur lors de la suppression de l'utilisateur.";
            $messageType = "error";
        }
    }
}

// Récupération de l'utilisateur à modifier
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $idUtilisateur = (int)$_GET['id'];
    $utilisateurEdit = getUserById($idUtilisateur);
    
    // Récupération de l'adresse si elle existe
    if ($utilisateurEdit && !empty($utilisateurEdit['id_adresse'])) {
        $adresse = getUserAddress($idUtilisateur);
        if ($adresse) {
            $utilisateurEdit['adresse'] = $adresse;
        }
    }
}

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $idUtilisateur = (int)$_POST['id'];
    
    $userData = [
        'civilite' => $_POST['civilite'],
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'statut' => $_POST['statut']
    ];
    
    // Mise à jour du mot de passe uniquement s'il est fourni
    if (!empty($_POST['motDePasse'])) {
        $userData['motDePasse'] = $_POST['motDePasse'];
    }
    
    // Mise à jour de l'utilisateur
    if (updateUser($idUtilisateur, $userData)) {
        // Mise à jour de l'adresse si fournie
        if (!empty($_POST['rue']) && !empty($_POST['ville']) && !empty($_POST['codePostal']) && !empty($_POST['pays'])) {
            $adresseData = [
                'rue' => $_POST['rue'],
                'ville' => $_POST['ville'],
                'codePostal' => $_POST['codePostal'],
                'pays' => $_POST['pays']
            ];
            
            // Si l'utilisateur a déjà une adresse, on la met à jour, sinon on en crée une nouvelle
            if (!empty($utilisateurEdit['id_adresse'])) {
                // Mise à jour de l'adresse existante (fonction à créer dans functions.php)
                updateUserAddress($idUtilisateur, $adresseData);
            } else {
                // Création d'une nouvelle adresse
                addUserAddress($idUtilisateur, $adresseData);
            }
        }
        
        $message = "Utilisateur mis à jour avec succès.";
        $messageType = "success";
        $utilisateurs = getAllUsers(); // Rafraîchir la liste
        $utilisateurEdit = null; // Fermer le formulaire d'édition
    } else {
        $message = "Erreur lors de la mise à jour de l'utilisateur.";
        $messageType = "error";
    }
}

// Traitement du changement de statut
if (isset($_GET['action']) && $_GET['action'] === 'changestatus' && isset($_GET['id']) && isset($_GET['status'])) {
    $idUtilisateur = (int)$_GET['id'];
    $nouveauStatut = $_GET['status'];
    
    // Vérifier que le statut est valide
    $statutsValides = ['client', 'admin'];
    if (in_array($nouveauStatut, $statutsValides)) {
        // Vérifier que l'utilisateur ne change pas son propre statut
        if ($idUtilisateur === (int)$_SESSION['user']['id']) {
            $message = "Vous ne pouvez pas changer votre propre statut.";
            $messageType = "error";
        } else {
            if (updateUser($idUtilisateur, ['statut' => $nouveauStatut])) {
                $message = "Statut de l'utilisateur mis à jour avec succès.";
                $messageType = "success";
                $utilisateurs = getAllUsers(); // Rafraîchir la liste
            } else {
                $message = "Erreur lors de la mise à jour du statut.";
                $messageType = "error";
            }
        }
    } else {
        $message = "Statut non valide.";
        $messageType = "error";
    }
}
require_once('../includes/header.php');
?>

<section class="admin-section">
    <div class="admin-container">
        <h2>Gestion des utilisateurs</h2>
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= $messageType === 'success' ? 'alert-success' : 'alert-danger' ?>">
                <p><?= $message ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($utilisateurEdit): ?>
        <div class="edit-form-container">
            <h3>Modifier l'utilisateur</h3>
            <form method="POST" action="" class="edit-form">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= $utilisateurEdit['id'] ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Civilité</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" name="civilite" id="civiliteM" value="M" <?= $utilisateurEdit['civilite'] === 'M' ? 'checked' : '' ?> required>
                                <label for="civiliteM">M.</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" name="civilite" id="civiliteMme" value="Mme" <?= $utilisateurEdit['civilite'] === 'Mme' ? 'checked' : '' ?> required>
                                <label for="civiliteMme">Mme</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-select" id="statut" name="statut" required>
                            <option value="client" <?= $utilisateurEdit['statut'] === 'client' ? 'selected' : '' ?>>Client</option>
                            <option value="admin" <?= $utilisateurEdit['statut'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($utilisateurEdit['nom']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($utilisateurEdit['prenom']) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($utilisateurEdit['email']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($utilisateurEdit['telephone']) ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="motDePasse" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" class="form-control" id="motDePasse" name="motDePasse">
                </div>
                
                <h4>Adresse</h4>
                <div class="form-row">
                    <div class="form-group">
                        <label for="rue" class="form-label">Rue</label>
                        <input type="text" class="form-control" id="rue" name="rue" 
                               value="<?= isset($utilisateurEdit['adresse']['rue']) ? htmlspecialchars($utilisateurEdit['adresse']['rue']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" 
                               value="<?= isset($utilisateurEdit['adresse']['ville']) ? htmlspecialchars($utilisateurEdit['adresse']['ville']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="codePostal" class="form-label">Code postal</label>
                        <input type="text" class="form-control" id="codePostal" name="codePostal" 
                               value="<?= isset($utilisateurEdit['adresse']['codePostal']) ? htmlspecialchars($utilisateurEdit['adresse']['codePostal']) : '' ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="pays" class="form-label">Pays</label>
                        <select class="form-select" id="pays" name="pays">
                            <option value="" <?= !isset($utilisateurEdit['adresse']['pays']) ? 'selected' : '' ?>>Choisissez un pays</option>
                            <option value="France" <?= (isset($utilisateurEdit['adresse']['pays']) && $utilisateurEdit['adresse']['pays'] === 'France') ? 'selected' : '' ?>>France</option>
                            <option value="Belgique" <?= (isset($utilisateurEdit['adresse']['pays']) && $utilisateurEdit['adresse']['pays'] === 'Belgique') ? 'selected' : '' ?>>Belgique</option>
                            <option value="Suisse" <?= (isset($utilisateurEdit['adresse']['pays']) && $utilisateurEdit['adresse']['pays'] === 'Suisse') ? 'selected' : '' ?>>Suisse</option>
                            <option value="Luxembourg" <?= (isset($utilisateurEdit['adresse']['pays']) && $utilisateurEdit['adresse']['pays'] === 'Luxembourg') ? 'selected' : '' ?>>Luxembourg</option>
                            <option value="Canada" <?= (isset($utilisateurEdit['adresse']['pays']) && $utilisateurEdit['adresse']['pays'] === 'Canada') ? 'selected' : '' ?>>Canada</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Mettre à jour</button>
                    <a href="<?= RACINE_SITE ?>admin/manageUtilisateurs.php" class="btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
        <?php endif; ?>
        
        <div class="users-table-container">
            <!-- <h3>Liste des utilisateurs</h3> -->
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date d'inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($utilisateurs)): ?>
                            <tr>
                                <td colspan="8">Aucun utilisateur trouvé.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($utilisateurs as $utilisateur): ?>
                                <tr>
                                    <td><?= $utilisateur['id'] ?></td>
                                    <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                                    <td><?= htmlspecialchars($utilisateur['prenom']) ?></td>
                                    <td><?= htmlspecialchars($utilisateur['email']) ?></td>
                                    <td><?= htmlspecialchars($utilisateur['telephone']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($utilisateur['dateInscription'])) ?></td>
                                    <td>
                                        <div class="status-dropdown">
                                            <span class="status-badge <?= strtolower($utilisateur['statut']) ?>"><?= ucfirst($utilisateur['statut']) ?></span>
                                            
                                            <?php if ((int)$utilisateur['id'] !== (int)$_SESSION['user']['id']): ?>
                                            <div class="status-dropdown-content">
                                                <a href="?action=changestatus&id=<?= $utilisateur['id'] ?>&status=client" class="status-option client">Client</a>
                                                <a href="?action=changestatus&id=<?= $utilisateur['id'] ?>&status=admin" class="status-option admin">Administrateur</a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <a href="?action=edit&id=<?= $utilisateur['id'] ?>" class="btn-edit">Modifier</a>
                                        
                                        <?php if ((int)$utilisateur['id'] !== (int)$_SESSION['user']['id']): ?>
                                        <a href="?action=delete&id=<?= $utilisateur['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php
require_once('../includes/footer.php');
?>