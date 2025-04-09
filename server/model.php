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


    function getMoviesByCategory($age) {
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
                    WHERE  :age = 0 OR Movie.min_age <= :age
                    ORDER BY Category.name, Movie.name";
    
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ); // Récupère tous les résultats sous forme d'objets
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


    function addProfile($id, $name, $avatar, $min_age) {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Si un ID est fourni, on effectue une mise à jour, sinon un ajout
            if ($id) {
                $sql = "UPDATE Profil SET name = :name, avatar = :avatar, min_age = :min_age WHERE id = :id";
                $stmt = $cnx->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                $sql = "INSERT INTO Profil (name, avatar, min_age) VALUES (:name, :avatar, :min_age)";
                $stmt = $cnx->prepare($sql);
            }
    
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
            $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);
    
            $stmt->execute();
            return $stmt->rowCount(); // Retourne le nombre de lignes affectées
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return false;
        }
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


    function addFavorite($profile_id, $movie_id) {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $sql = "INSERT INTO Favorites (profile_id, movie_id) VALUES (:profile_id, :movie_id)";
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
            $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
            $stmt->execute();
    
            error_log("Favori ajouté : profile_id = $profile_id, movie_id = $movie_id");
            return $stmt->rowCount(); // Retourne le nombre de lignes affectées
        } catch (Exception $e) {
            error_log("Erreur SQL dans addFavorite : " . $e->getMessage());
            return false;
        }
    }
    
    
    function getFavorites($profile_id) {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $sql = "SELECT Movie.id, Movie.name, Movie.image 
                    FROM Favorites 
                    JOIN Movie ON Favorites.movie_id = Movie.id 
                    WHERE Favorites.profile_id = :profile_id";
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
            $stmt->execute();
            $favorites = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $favorites ?: []; // Retourne un tableau vide si aucun favori n'est trouvé
        } catch (Exception $e) {
            error_log("Erreur SQL (getFavorites) : " . $e->getMessage());
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }
    
    function isFavorite($profile_id, $movie_id) {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "SELECT COUNT(*) FROM Favorites WHERE profile_id = :profile_id AND movie_id = :movie_id";
        $stmt = $cnx->prepare($sql);
        $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
        $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
        }
    
    function removeFavorite($profile_id, $movie_id) {
        try {
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $sql = "DELETE FROM Favorites WHERE profile_id = :profile_id AND movie_id = :movie_id";
            $stmt = $cnx->prepare($sql);
            $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
            $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount(); // Retourne le nombre de lignes supprimées
        } catch (Exception $e) {
            error_log("Erreur SQL (removeFavorite) : " . $e->getMessage());
            return false; // Retourne false en cas d'erreur
        }
    }