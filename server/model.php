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

    function getMovieTrailer($id) {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    
            // Requête SQL avec jointure pour récupérer les détails du film et le nom de la catégorie
            $sql = "SELECT 
                        Movie.id, 
                        Movie.name, 
                        Movie.director, 
                        Movie.year, 
                        Movie.length, 
                        Movie.description, 
                        Movie.image, 
                        Movie.trailer, 
                        Movie.min_age, 
                        Movie.id_category, 
                        Category.name AS category
                    FROM Movie
                    JOIN Category ON Movie.id_category = Category.id
                    WHERE Movie.id = :id";
    
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_OBJ); // Retourne les détails du film sous forme d'objet
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage()); // Log dans les erreurs PHP
            return false;
        }
    }


    function getMoviesByCategory() {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    
            // Requête SQL pour récupérer les films groupés par catégorie
            $sql = "SELECT 
                        Category.id AS category_id, 
                        Category.name AS category_name, 
                        Movie.id AS movie_id, 
                        Movie.name AS movie_name, 
                        Movie.image AS movie_image
                    FROM Movie
                    JOIN Category ON Movie.id_category = Category.id
                    ORDER BY Category.name, Movie.name";
    
            $stmt = $cnx->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            // Regrouper les films par catégorie
            $categories = [];
            foreach ($rows as $row) {
                if (!isset($categories[$row->category_id])) {
                    $categories[$row->category_id] = [
                        "name" => $row->category_name,
                        "movies" => []
                    ];
                }
                $categories[$row->category_id]["movies"][] = [
                    "id" => $row->movie_id,
                    "name" => $row->movie_name,
                    "image" => $row->movie_image
                ];
            }
    
            return array_values($categories); // Retourne un tableau indexé
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }


    function addProfile($name, $avatar, $min_age) {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    
        $sql = "INSERT INTO Profil (name, avatar, min_age) 
                VALUES (:name, :avatar, :min_age)";
    
        $stmt = $cnx->prepare($sql);
    
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->bindParam(':min_age', $min_age);
    
        $stmt->execute();
        $res = $stmt->rowCount();
        return $res; // Retourne le nombre de lignes affectées par l'opération
    }


    function getProfiles() {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    
            // Requête SQL pour récupérer les profils
            $sql = "SELECT id, name, avatar, min_age FROM Profil";
            $stmt = $cnx->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ); // Retourne les profils sous forme d'objets
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
    }

    function addFavorites($id_profile, $id_movie) {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "INSERT INTO Favorites (id_profile, id_movie) VALUES (:id_profile, :id_movie)";
        error_log("Ajout aux favoris : id_profile = $id_profile, id_movie = $id_movie");
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id_profile', $id_profile, PDO::PARAM_INT);
        $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function getFavorites($id_profile) { 
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "SELECT Movie.id, Movie.name, Movie.image FROM Favorites 
                JOIN Movie ON Favorites.id_movie = Movie.id 
                WHERE Favorites.id_profile = :id_profile"; 
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id_profile', $id_profile, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    function removeFavorites($id_profile, $id_movie) { 
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
            $sql = "DELETE FROM Favorites WHERE id_profile = :id_profile AND id_movie = :id_movie"; 
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':id_profile', $id_profile, PDO::PARAM_INT); 
            $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
            $result = $stmt->execute();
            error_log("Requête SQL exécutée : $sql avec id_profile = $id_profile et id_movie = $id_movie");
            return $result;
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression des favoris : " . $e->getMessage());
            return false;
        }
    }
    
    function isFavorites($id_profile, $id_movie) { 
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "SELECT COUNT(*) FROM Favorites WHERE id_profile = :id_profile AND id_movie = :id_movie"; 
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':id_profile', $id_profile, PDO::PARAM_INT); 
        $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }


    function getFeaturedMovies() {
        try {
            error_log("Début de getFeaturedMovies"); // Log avant la connexion
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
            $sql = "SELECT id, name, description, image FROM Movie WHERE is_featured = 1";
            error_log("Requête SQL : $sql"); // Log de la requête
            $stmt = $cnx->query($sql);
            $movies = $stmt->fetchAll(PDO::FETCH_OBJ);
            error_log("Films mis en avant : " . print_r($movies, true)); // Log des résultats
            return $movies;
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return [];
        }
    }