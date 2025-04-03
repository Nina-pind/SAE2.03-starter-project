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
    $stm = $csx->prepare($sql);
    $stmt ->execute();
    $res= $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
    return $res; // Retourne le tableau des films
}

