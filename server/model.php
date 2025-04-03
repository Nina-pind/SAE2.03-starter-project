<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "pinardel2");
define("DBLOGIN", "pinardel2");
define("DBPWD", "pinardel2");

function getAllMovies(){
    // Connexion à la base de données
    $snx = new PDO("mysql:host=".HOST. ";dbname=" .DBLOGIN, DBPWD, DBNAME);
    
    $sql = "selecte id, name, image from Movie";
    $stm = $conn->query($sql);
    
    // Vérification du résultat de la requête
    if ($result === false) {
        return false; // Erreur dans la requête SQL
    }
    
    // Récupération des résultats sous forme de tableau associatif
    $movies = $result->fetch_all(MYSQLI_ASSOC);
    
    // Fermeture de la connexion à la base de données
    $conn->close();
    
    return $movies; // Retourne le tableau des films
}