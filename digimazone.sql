-- creation de la base de données digimazone si elle n'existe pas déjà avec l'ensemble des fonctionnalités sql qui nous permettent de n'avoir aucune erreur
-- et de ne pas avoir de problème d'insertion de données
-- Suppression de la base de données si elle existe déjà
DROP DATABASE IF EXISTS digimazone;
-- Création de la base de données
CREATE DATABASE digimazone;
-- Utilisation de la base de données
USE digimazone;
-- encodage utf8mb4 pour les caractères spéciaux
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET character_set_connection=utf8mb4;
SET character_set_results=utf8mb4;
SET character_set_client=utf8mb4;

-- Création des tables avec les colonnes et les types de données appropriés
-- et les contraintes nécessaires pour assurer l'intégrité des données
-- et les relations entre les tables
-- Table utilisateurs
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT, -- NOUVEAU
    civilite ENUM('M', 'Mme') NOT NULL, -- NOUVEAU
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    motDePasse VARCHAR(255) NOT NULL, -- NOUVEAU
    telephone VARCHAR(15) NOT NULL,
    dateNaissance DATE NOT NULL, -- NOUVEAU
    dateInscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP, /* NOUVEAU */
    statut ENUM('client', 'admin') NOT NULL DEFAULT 'client' -- NOUVEAU,
    id_adresse INT, -- NOUVEAU
    FOREIGN KEY (id_adresse) REFERENCES adresses(id) ON DELETE SET NULL, -- NOUVEAU
);
-- Table adresses : la table adresses permet de gérer les adresses de livraison des utilisateurs
CREATE TABLE adresses(
    id INT PRIMARY KEY AUTO_INCREMENT,
    rue TEXT NOT NULL,
    ville VARCHAR(50) NOT NULL,
    codePostal VARCHAR(10) NOT NULL,
    pays VARCHAR(50) NOT NULL,
    dateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table produits
CREATE TABLE produits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    descriptif TEXT NOT NULL, --NOUVEAU
    prix DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    -- imageUrl TEXT NOT NULL, -- NOUVEAU
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE CASCADE,
    id_utilisateur INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE image_produits(
    id INT PRIMARY KEY AUTO_INCREMENT,
    imageUrl TEXT NOT NULL,
    id_produit INT NOT NULL,
    position INT NOT NULL, -- NOUVEAU
    FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE
);

CREATE TABLE categories(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    descriptif TEXT NOT NULL, -- NOUVEAU
    codeCouleur VARCHAR(7) NOT NULL
);

-- Table étiquettes : la table étiquettes permet de gérer les étiquettes associées aux produits
CREATE TABLE etiquettes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE CASCADE
);

-- Table produits_etiquettes : la table produits_etiquettes permet de gérer les relations entre les produits et les étiquettes
CREATE TABLE produits_etiquettes(
    id_produit INT NOT NULL,
    id_etiquette INT NOT NULL,
    PRIMARY KEY (id_produit, id_etiquette),
    FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE,
    FOREIGN KEY (id_etiquette) REFERENCES etiquettes(id) ON DELETE CASCADE
);

-- Table commandes : la table commandes permet de gérer les commandes passées par les utilisateurs
-- et de stocker les informations relatives à chaque commande
CREATE TABLE commandes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    dateCommande DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en attente', 'expédiée', 'annulée') NOT NULL DEFAULT 'en attente',
    total DECIMAL(10, 2) NOT NULL,
    id_utilisateur INT NOT NULL,
    id_panier INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    -- FOREIGN KEY (id_panier) REFERENCES paniers(id) ON DELETE CASCADE
);

-- Table details_commandes : la table details_commandes permet de gérer les détails de chaque commande
-- et de stocker les informations relatives à chaque produit commandé
-- et à chaque utilisateur ayant passé la commande
-- et à chaque panier associé à la commande
-- et à chaque produit associé à la commande
CREATE TABLE details_commandes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_commande INT NOT NULL,
    id_produit INT NOT NULL,
    quantite INT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_commande) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE
);

-- -- Table paniers : la table paniers permet de gérer les paniers d'achats des utilisateurs
-- CREATE TABLE paniers(
--     id INT PRIMARY KEY AUTO_INCREMENT,
--     id_utilisateur INT NOT NULL,
--     FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE
-- );

-- -- Table paniers_produits : la table paniers_produits permet de gérer les produits ajoutés au panier
-- CREATE TABLE paniers_produits(
--     id_panier INT NOT NULL,
--     id_produit INT NOT NULL,
--     quantite INT NOT NULL,
--     PRIMARY KEY (id_panier, id_produit),
--     FOREIGN KEY (id_panier) REFERENCES paniers(id) ON DELETE CASCADE,
--     FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE
-- );

CREATE TABLE paiements(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_commande INT NOT NULL,
    methodePaiement ENUM('CB', 'Paypal', 'Stripe') NOT NULL,
    statutPaiement ENUM('en attente', 'payé', 'échoué') NOT NULL DEFAULT 'en attente',
    datePaiement DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_commande) REFERENCES commandes(id) ON DELETE CASCADE
);

CREATE TABLE avis(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_produit INT NOT NULL,
    id_utilisateur INT NOT NULL,
    note INT CHECK (note >= 1 AND note <= 5), -- NOUVEAU
    commentaire TEXT NOT NULL,
    dateAvis DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produit) REFERENCES produits(id) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- Comment la table panier est-elle lié à la commande ?
-- La table panier est liée à la commande par l'intermédiaire de la table details_commandes
-- qui contient les informations relatives à chaque produit commandé
-- et à chaque utilisateur ayant passé la commande
-- et à chaque panier associé à la commande
-- et à chaque produit associé à la commande
-- La table details_commandes contient une colonne id_panier qui fait référence à la table paniers
-- et une colonne id_commande qui fait référence à la table commandes
-- et une colonne id_produit qui fait référence à la table produits
-- et une colonne id_utilisateur qui fait référence à la table utilisateurs
-- et une colonne quantite qui fait référence à la table produits
-- et une colonne prix qui fait référence à la table produits

/*
Comment relier le Panier à une Commande ?
Actuellement, il n’y a aucune relation directe entre paniers et commandes.
L’objectif est que lorsqu'un utilisateur valide son panier, tous les produits du panier doivent être copiés dans details_commandes et associés à une nouvelle commande.

Solution à appliquer :
Ajout d’un champ id_panier dans commandes
Cela permet de savoir quel panier a été converti en commande.
Modification de details_commandes
Au moment de la validation, les produits du panier sont transférés vers details_commandes.
*/
