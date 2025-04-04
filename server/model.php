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

    function addFilm($title, $director, $year, $duration, $description, $id_category, $poster, $trailer, $age_restriction) {
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


    function getMovieTrailer($id) {
        try {
            // Connexion à la base de données
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    
            // Requête SQL pour récupérer les détails du film
            $sql = "SELECT id, name, director, year, durée, description, id_category, image, trailer, min_age 
                    FROM Movie 
                    WHERE id = :id";
    
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Récupère le résultat sous forme d'objet
            $movieTrailer = $stmt->fetch(PDO::FETCH_OBJ);
    
            return $movieTrailer; // Retourne les détails du film
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
            return false;
        }
    }