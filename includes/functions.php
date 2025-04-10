<?php
session_start();
define("RACINE_SITE", "http://localhost/digimazone/");
require_once("../config/config.php");

#### Condition pour se déconnecter
if (isset($_GET['action']) && $_GET['action'] === "deconnexion") {
    unset($_SESSION['user']);
    header("Location:" . RACINE_SITE . "index.php");
}

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