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
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $sql = "SELECT id, name, image FROM Movie";
            $answer = $cnx->query($sql);
            return $answer->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
            return false;
        }
    }

function addMovie($title, $director, $year, $duration, $description, $category, $post, $trailer, $age_restriction){
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "REPLACE INTO film (title, director, year, durée, description, id_category, image, trailer, min_age) 
        VALUES (:name, :director, :year, :durée, :description, :id_category, :image, :trailer, :min_age)";
}


$cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$sql = "INSERT INTO Movie (name, director, year, durée, description, id_category, image, trailer, min_age) 
        VALUES (:name, :director, :year, :durée, :description, :id_category, :image, :trailer, :min_age)";
$stmt = $cnx->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':director', $director);
$stmt->bindParam(':year', $year);
$stmt->bindParam(':durée', $durée);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':id_category', $id_category);
$stmt->bindParam(':image', $image);
$stmt->bindParam(':trailer', $trailer);
$stmt->bindParam(':min_age', $min_age);
return $stmt->execute(); // Retourne true si l'insertion a réussi, false sinon
} catch (Exception $e) {
error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
return false;
}