<?php
session_start();
define("RACINE_SITE", "http://localhost/digimazone/");
// require_once(RACINE_SITE."config/config.php");

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'digimazone');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

#### Création d'une fonction alerte
function alert(string $message, string $type = "danger"): string
{
    return "<div class='alert alert-$type alert-dismissible fade show text-center w-50 m-auto mb-5' role='alert'>
    $message
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
}

#### Fonction pour debuger
function debug($var): void
{
    echo "<pre class='border border-dark bg-light text-danger fw-bold w-50 p-5 mt-5'>";
    var_dump($var);
    echo "</pre>";
}

#### connexion à la BDD
function connexionBDD(): object
{
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

    try {
        // C'est quoi PDO ? Pourquoi on l'utilise ?
        // PDO est une extension PHP qui définit une interface pour accéder à une base de données depuis PHP
        $pdo = new PDO($dsn, DB_USER, DB_PASS); // il crée une instance de la classe PDO (d'un objet) qui est une classe prédéfinie en PHP, elle implémente des interfaces pour accéder à une base de données tels que MySQL, PostgreSQL, etc.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // echo "Je suis connecté à la BDD";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
    return $pdo;
}

/**
 * Crée un nouvel utilisateur dans la base de données
 * @param array $data Les données de l'utilisateur à créer
 * @return bool|int False en cas d'échec, l'ID du nouvel utilisateur en cas de succès
 */
function createUser(array $data): bool|int
{
    // Vérification des données requises
    if (empty($data['civilite']) || empty($data['nom']) || empty($data['prenom']) || 
        empty($data['email']) || empty($data['motDePasse']) || empty($data['telephone']) || 
        empty($data['dateNaissance'])) {
        return false;
    }

    // Vérification si l'email existe déjà
    if (getUserByEmail($data['email'])) {
        return false;
    }

    try {
        $pdo = connexionBDD();
        
        // Hashage du mot de passe
        $motDePasseHash = password_hash($data['motDePasse'], PASSWORD_DEFAULT);
        
        // Gestion du statut (par défaut 'client' si non spécifié)
        $statut = isset($data['statut']) ? $data['statut'] : 'client';
        
        $sql = "INSERT INTO utilisateurs (civilite, nom, prenom, email, motDePasse, telephone, dateNaissance, statut) 
                 VALUES (:civilite, :nom, :prenom, :email, :motDePasse, :telephone, :dateNaissance, :statut)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'civilite' => $data['civilite'],
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'motDePasse' => $motDePasseHash,
            'telephone' => $data['telephone'],
            'dateNaissance' => $data['dateNaissance'],
            'statut' => $statut
        ]);
        
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        // Journalisation de l'erreur
        error_log("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère un utilisateur par son ID
 * @param int $id L'ID de l'utilisateur
 * @return array|false Les données de l'utilisateur ou false si non trouvé
 */
function getUserById(int $id): array|false
{
    try {
        $pdo = connexionBDD();
        
        $sql = "SELECT * FROM utilisateurs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $user = $stmt->fetch();
        
        if ($user) {
            // Par sécurité, on ne renvoie pas le mot de passe
            unset($user['motDePasse']);
            return $user;
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère un utilisateur par son email
 * @param string $email L'email de l'utilisateur
 * @return array|false Les données de l'utilisateur ou false si non trouvé
 */
function getUserByEmail(string $email): array|false
{
    try {
        $pdo = connexionBDD();
        
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        $user = $stmt->fetch();
        
        if ($user) {
            // Par sécurité, on ne renvoie pas le mot de passe dans le résultat
            unset($user['motDePasse']);
            return $user;
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'utilisateur par email : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère tous les utilisateurs
 * @param int $limit Nombre maximum d'utilisateurs à récupérer
 * @param int $offset À partir de quel utilisateur commencer
 * @return array Le tableau des utilisateurs
 */
function getAllUsers(int $limit = 100, int $offset = 0): array
{
    try {
        $pdo = connexionBDD();
        
        $sql = "SELECT * FROM utilisateurs ORDER BY dateInscription DESC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $users = $stmt->fetchAll();
        
        // Retirer les mots de passe de tous les utilisateurs
        foreach ($users as &$user) {
            unset($user['motDePasse']);
        }
        
        return $users;
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de tous les utilisateurs : " . $e->getMessage());
        return [];
    }
}

/**
 * Met à jour les informations d'un utilisateur
 * @param int $id ID de l'utilisateur à mettre à jour
 * @param array $data Les nouvelles données
 * @return bool True si succès, false si erreur
 */
function updateUser(int $id, array $data): bool
{
    try {
        $pdo = connexionBDD();
        
        // Construire la requête dynamiquement en fonction des champs fournis
        $setClause = [];
        $params = ['id' => $id];
        
        $allowedFields = ['civilite', 'nom', 'prenom', 'email', 'telephone', 'dateNaissance', 'statut', 'id_adresse'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $setClause[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }
        
        // Traitement spécial pour le mot de passe
        if (!empty($data['motDePasse'])) {
            $setClause[] = "motDePasse = :motDePasse";
            $params['motDePasse'] = password_hash($data['motDePasse'], PASSWORD_DEFAULT);
        }
        
        if (empty($setClause)) {
            return false; // Aucun champ à mettre à jour
        }
        
        // Requête de mise à jour dynamique d'utilisateur
        // On utilise implode pour créer la chaîne de mise à jour
        $sql = "UPDATE utilisateurs SET " . implode(', ', $setClause) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
        return false;
    }
}

/**
 * Supprime un utilisateur par son ID
 * @param int $id L'ID de l'utilisateur à supprimer
 * @return bool True si succès, false si erreur
 */
function deleteUser(int $id): bool
{
    try {
        $pdo = connexionBDD();
        
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
        return false;
    }
}

/**
 * Authentifie un utilisateur
 * @param string $email L'email de l'utilisateur
 * @param string $password Le mot de passe en clair
 * @return array|false Les données de l'utilisateur si authentification réussie, false sinon
 */
function authenticateUser(string $email, string $password): array|false
{
    try {
        $pdo = connexionBDD();
        
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['motDePasse'])) { // Vérification du mot de passe hashé
            // Authentification réussie, on stocke les informations de l'utilisateur dans la session
            // Ne pas retourner le mot de passe hashé
            unset($user['motDePasse']);
            return $user;
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("Erreur lors de l'authentification : " . $e->getMessage());
        return false;
    }
}

/**
 * Déconnecte l'utilisateur actuel en détruisant la session
 * Cette fonction termine la session sans utiliser de cookies
 * @return void
 */
function logoutUser(): void
{
    // Vider le tableau de session
    $_SESSION = [];
    
    // Détruire la session
    session_destroy();
    
    // Rediriger vers la page d'accueil
    header('Location: ' . RACINE_SITE . 'index.php');
    exit();
}

/**
 * Ajoute une adresse à un utilisateur
 * @param int $userId L'ID de l'utilisateur
 * @param array $adresseData Les données de l'adresse
 * @return bool|int False en cas d'échec, l'ID de la nouvelle adresse en cas de succès
 */
function addUserAddress(int $userId, array $adresseData): bool|int
{
    try {
        $pdo = connexionBDD();
        
        // Transaction pour s'assurer que toutes les opérations réussissent ou échouent ensemble
        $pdo->beginTransaction(); 
        
        // Insérer l'adresse
        $sqlAdresse = "INSERT INTO adresses (rue, ville, codePostal, pays) 
                        VALUES (:rue, :ville, :codePostal, :pays)";
        
        $stmtAdresse = $pdo->prepare($sqlAdresse);
        $stmtAdresse->execute([
            'rue' => $adresseData['rue'],
            'ville' => $adresseData['ville'],
            'codePostal' => $adresseData['codePostal'],
            'pays' => $adresseData['pays']
        ]);
        
        $adresseId = $pdo->lastInsertId();
        
        // Mettre à jour l'utilisateur avec l'ID de l'adresse
        $sqlUser = "UPDATE utilisateurs SET id_adresse = :id_adresse WHERE id = :id";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute([
            'id_adresse' => $adresseId,
            'id' => $userId
        ]);
        
        $pdo->commit();
        return $adresseId;
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) { // Vérifie si une transaction est en cours
            $pdo->rollBack(); // Annule toutes les opérations effectuées depuis le début de la transaction
        }
        error_log("Erreur lors de l'ajout d'adresse : " . $e->getMessage());
        return false;
    }
}

/**
 * Récupère l'adresse d'un utilisateur
 * @param int $userId L'ID de l'utilisateur
 * @return array|false Les données de l'adresse ou false si non trouvée
 */
function getUserAddress(int $userId): array|false
{
    try {
        $pdo = connexionBDD();
        
        $sql = "SELECT a.* FROM adresses a 
                  JOIN utilisateurs u ON u.id_adresse = a.id 
                  WHERE u.id = :userId";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération de l'adresse : " . $e->getMessage());
        return false;
    }
}

/**
 * Met à jour l'adresse d'un utilisateur
 * @param int $userId L'ID de l'utilisateur
 * @param array $adresseData Les nouvelles données de l'adresse
 * @return bool True si succès, false si erreur
 */

function updateUserAddress(int $userId, array $adresseData): bool
{
    try {
        $pdo = connexionBDD();
        
        // Mettre à jour l'adresse
        $sql = "UPDATE adresses SET rue = :rue, ville = :ville, codePostal = :codePostal, pays = :pays 
                  WHERE id = (SELECT id_adresse FROM utilisateurs WHERE id = :userId)";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'rue' => $adresseData['rue'],
            'ville' => $adresseData['ville'],
            'codePostal' => $adresseData['codePostal'],
            'pays' => $adresseData['pays'],
            'userId' => $userId
        ]);
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour de l'adresse : " . $e->getMessage());
        return false;
    }
}

