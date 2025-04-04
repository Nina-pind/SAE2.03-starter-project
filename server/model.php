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

    function addFilm($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age) {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    
            $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
                    VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";
            $stmt = $cnx->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':director' => $director,
                ':year' => $year,
                ':length' => $length,
                ':description' => $description,
                ':id_category' => $id_category,
                ':image' => $image,
                ':trailer' => $trailer,
                ':min_age' => $min_age
            ]);
    
            return true;
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }


function addMovie($title, $director, $year, $duration, $description, $id_category, $poster, $trailer, $age_restriction) {
    try {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $sql = "INSERT INTO Movie (title, director, year, duration, description, id_category, poster, trailer, age_restriction) 
                VALUES (:title, :director, :year, :duration, :description, :id_category, :poster, :trailer, :age_restriction)";
        $stmt = $cnx->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':director' => $director,
            ':year' => $year,
            ':duration' => $duration,
            ':description' => $description,
            ':id_category' => $id_category,
            ':poster' => $poster,
            ':trailer' => $trailer,
            ':age_restriction' => $age_restriction
        ]);

        return true;
    } catch (Exception $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return false;
    }
}