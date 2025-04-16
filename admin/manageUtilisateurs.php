<?php
require_once('../includes/functions.php');
$h1 = "Gestion des utilisateurs - Digimazone";
$boostrapHeader = '';
$boostrapFooter = '';
require_once('../includes/header.php');

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
            <h3>Liste des utilisateurs</h3>
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

<style>
.admin-section {
    padding: 50px 0;
    margin-top: 30px;
}

.admin-container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

/* Tableau des utilisateurs */
.users-table-container {
    margin-top: 30px;
}

.table-responsive {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.users-table th, .users-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.users-table th {
    background-color: var(--backgroundcolorsecondary);
    color: var(--titlecolor);
    font-weight: bold;
}

.users-table tr:hover {
    background-color: var(--backgroundcolor);
}

.users-table td.actions {
    white-space: nowrap;
}

/* Menu déroulant de statut */
.status-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 600;
    cursor: pointer;
}

.status-badge.admin {
    background-color: #6c5ce7;
    color: white;
}

.status-badge.client {
    background-color: #0984e3;
    color: white;
}

.status-dropdown {
    position: relative;
    display: inline-block;
}

.status-dropdown-content {
    display: none;
    position: absolute;
    background-color: var(--backgroundcolor);
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
}

.status-dropdown:hover .status-dropdown-content {
    display: block;
}

.status-option {
    color: var(--primarycolor);
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.status-option:hover {
    background-color: var(--backgroundcolorsecondary);
}

.status-option.admin:hover {
    color: #6c5ce7;
}

.status-option.client:hover {
    color: #0984e3;
}

/* Boutons d'action */
.btn-edit, .btn-delete {
    padding: 5px 10px;
    border-radius: 3px;
    color: white;
    text-decoration: none;
    font-size: 0.9em;
    margin-right: 5px;
    display: inline-block;
}

.btn-edit {
    background-color: #FFDE00;
    color: #0d0c22;
}

.btn-delete {
    background-color: #e74c3c;
}

.btn-edit:hover {
    background-color: #ffbb00;
}

.btn-delete:hover {
    background-color: #c0392b;
}

/* Formulaire d'édition */
.edit-form-container {
    background-color: var(--backgroundcolor);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
}

.form-row .form-group {
    flex: 1;
    min-width: 250px;
}

.form-group {
    margin-bottom: 15px;
}

.form-label {
    display: block;
    color: var(--primarycolor);
    margin-bottom: 8px;
    font-weight: 600;
}

.form-control, .form-select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    background-color: light-dark(#fff, #333);
    color: var(--primarycolor);
}

.radio-group {
    display: flex;
    gap: 15px;
}

.radio-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.form-actions {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
    margin-top: 20px;
}

.btn-primary, .btn-secondary {
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
    border: none;
    display: inline-block;
}

.btn-primary {
    background-color: #FFDE00;
    color: #0d0c22;
}

.btn-secondary {
    background-color: #95a5a6;
    color: white;
}

.btn-primary:hover {
    background-color: #ffbb00;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
}

/* Adaptations mode sombre */
html.dark .users-table th {
    background-color: #2d2d2d;
}

html.dark .users-table td {
    border-color: #444;
}

html.dark .form-control, html.dark .form-select {
    background-color: #333;
    color: #f5f5f5;
    border-color: #555;
}

html.dark .alert-success {
    background-color: #1e4031;
    border-color: #2a5a44;
    color: #d4edda;
}

html.dark .alert-danger {
    background-color: #442a2d;
    border-color: #58383c;
    color: #f8d7da;
}

html.dark .status-dropdown-content {
    background-color: #2d2d2d;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.5);
}

html.dark .status-option:hover {
    background-color: #3a3a3a;
}

@media screen and (max-width: 768px) {
    .form-row {
        flex-direction: column;
    }
    
    .form-row .form-group {
        width: 100%;
    }
    
    .users-table {
        font-size: 0.9rem;
    }
    
    .users-table th, .users-table td {
        padding: 8px 10px;
    }
    
    .btn-edit, .btn-delete {
        padding: 4px 8px;
        font-size: 0.8em;
    }
}
</style>
<?php
require_once('../includes/footer.php');
?>