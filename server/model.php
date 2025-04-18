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

function getAllMovies() {
    // Connexion à la base de données
    $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
    ]);

    // Vérifie si la connexion a échoué
    if (!$cnx) {
        return false;
    }

    $sql = "SELECT id, name, image FROM Movie";
    $answer = $cnx->query($sql);

    // Vérifie si la requête a échoué
    if (!$answer) {
        return false;
    }

    return $answer->fetchAll(PDO::FETCH_OBJ);
}


function addFilm($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age) {
    $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
    ]);

    if (!$cnx) {
        return false;
    }

    $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";
    $stmt = $cnx->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $executed = $stmt->execute([
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

    return $executed;
}


function getMovieTrailer($id) {
    $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
    ]);

    if (!$cnx) {
        return false;
    }

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
                Movie.created_at, 
                Category.name AS category
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.id = :id";

    $stmt = $cnx->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $executed = $stmt->execute();

    if (!$executed) {
        return false;
    }

    return $stmt->fetch(PDO::FETCH_OBJ);
}



function getMoviesByCategory() {
    $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
    ]);

    if (!$cnx) {
        return false;
    }

    $sql = "SELECT 
                Category.id AS category_id, 
                Category.name AS category_name, 
                Movie.id AS movie_id, 
                Movie.name AS movie_name, 
                Movie.image AS movie_image,
                Movie.min_age AS movie_min_age 
            FROM Movie
            JOIN Category ON Movie.id_category = Category.id
            ORDER BY Category.name, Movie.name";


    $stmt = $cnx->query($sql);

    if (!$stmt) {
        return false;
    }

    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!$rows) {
        return false;
    }

    $categories = [];
    $count = count($rows);
    for ($i = 0; $i < $count; $i++) {
        $row = $rows[$i];
        if (!isset($categories[$row->category_id])) {
            $categories[$row->category_id] = [
                "name" => $row->category_name,
                "movies" => []
            ];
        }
        $categories[$row->category_id]["movies"][] = [
            "id" => $row->movie_id,
            "name" => $row->movie_name,
            "image" => $row->movie_image,
            "min_age" => $row->movie_min_age
        ];
    }

    return array_values($categories);
}

    

    function addProfile($name, $avatar, $min_age) {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "INSERT INTO Profil (name, avatar, min_age) 
        VALUES (:name, :avatar, :min_age)
        ON DUPLICATE KEY UPDATE 
            name = VALUES(name), 
            avatar = VALUES(avatar), 
            min_age = VALUES(min_age)";

    
        $stmt = $cnx->prepare($sql);
    
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $stmt->bindParam(':min_age', $min_age, PDO::PARAM_INT);
    
        $stmt->execute();
        $res = $stmt->rowCount();
        return $res; // Retourne le nombre de lignes affectées par l'opération
    }


    function getProfiles() {
        $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
        ]);
    
        if (!$cnx) {
            return false;
        }
    
        $sql = "SELECT id, name, avatar, min_age FROM Profil";
        $stmt = $cnx->query($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $profiles = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        if (!$profiles) {
            return false;
        }
    
        return $profiles;
    }
    

    function addFavorites($id_profile, $id_movie) {
        $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $sql = "INSERT INTO Favorites (id_profile, id_movie) VALUES (:id_profile, :id_movie)";
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
            $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
    
            $sql = "DELETE FROM Favorites WHERE id_profile = :id_profile AND id_movie = :id_movie";
            $stmt = $cnx->prepare($sql);
    
            $stmt->bindParam(':id_profile', $id_profile, PDO::PARAM_INT);
            $stmt->bindParam(':id_movie', $id_movie, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            // Pour le débug : log le message d'erreur dans un fichier
            file_put_contents("logs/errors.log", "Erreur removeFavorites: " . $e->getMessage() . "\n", FILE_APPEND);
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
        $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
        ]);
    
        if (!$cnx) {
            return [];
        }
    
        $sql = "SELECT id, name, description, image FROM Movie WHERE is_featured = 1";
        $stmt = $cnx->query($sql);
    
        if (!$stmt) {
            return [];
        }
    
        $movies = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        if (!$movies) {
            return [];
        }
    
        return $movies;
    }
    

    function searchMovies($keyword, $category = null, $year = null) {
        $cnx = @new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
        ]);
    
        if (!$cnx) {
            return false;
        }
    
        // On commence à construire la requête SQL
        $sql = "SELECT 
                Movie.id, 
                Movie.name, 
                Movie.image, 
                Movie.is_featured, 
                Category.name AS category 
            FROM Movie
            LEFT JOIN Category ON Movie.id_category = Category.id
            WHERE Movie.name LIKE :keyword";
    
        // Si une catégorie ou une année est précisée, on ajoute ces critères
        if ($category) {
            $sql .= " AND id_category = :category";
        }
        if ($year) {
            $sql .= " AND year = :year";
        }
    
        $stmt = $cnx->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        // On lie le paramètre de recherche
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    
        // On lie les paramètres supplémentaires si présents
        if ($category) {
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        }
        if ($year) {
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        }
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


function updateFeaturedStatus($movie_id, $is_featured) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "UPDATE Movie SET is_featured = :is_featured WHERE id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_BOOL);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}


function addRating($profile_id, $movie_id, $rating) {
$cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    $sql = "INSERT INTO Ratings (profile_id, movie_id, rating) VALUES (:profile_id, :movie_id, :rating)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getAverageRating($movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT AVG(rating) AS average_rating FROM Ratings WHERE movie_id = :movie_id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    $average = $stmt->fetch(PDO::FETCH_OBJ)->average_rating ?? 0;
    return round($average, 1);
}

function addComment($movie_id, $profile_id, $comment) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Comments (movie_id, profile_id, comment) VALUES (:movie_id, :profile_id, :comment)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    return $stmt->execute();
}

function getCommentsByMovie($movie_id) {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT 
                Comments.comment, 
                Comments.created_at, 
                Profil.name AS profile_name 
            FROM Comments 
            JOIN Profil ON Comments.profile_id = Profil.id 
            WHERE Comments.movie_id = :movie_id 
            ORDER BY Comments.created_at DESC";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getPendingComments() {
    $db = getDatabaseConnection();
    $query = "SELECT Comments.id, Comments.comment, Comments.created_at, Profil.name AS profile_name
              FROM Comments
              JOIN Profil ON Comments.profile_id = Profil.id
              WHERE Comments.status = 'pending'
              ORDER BY Comments.created_at DESC";
    $stmt = $db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function approveComment($commentId) {
    $db = getDatabaseConnection();
    $query = "UPDATE Comments SET status = 'approved' WHERE id = :id";
    $stmt = $db->prepare($query);
    return $stmt->execute(['id' => $commentId]);
}

function deleteComment($commentId) {
    $db = getDatabaseConnection();
    $query = "DELETE FROM Comments WHERE id = :id";
    $stmt = $db->prepare($query);
    return $stmt->execute(['id' => $commentId]);
}

function getDatabaseConnection() {
    try {
        $db = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

function getRecentMovies() {
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT id, name, image, created_at 
            FROM Movie 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $stmt = $cnx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}