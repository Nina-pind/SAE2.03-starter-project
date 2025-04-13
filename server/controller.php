<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");

function readmoviesController(){
  // on appelle la fonction de modèle readMovies() pour récupérer les films
  $movies = getAllMovies();
    return $movies;
}

function addFilmController() {
  $name = $_REQUEST['name'];
  $director = $_REQUEST['director'];
  $year = $_REQUEST['year'];
  $length = $_REQUEST['length'];
  $description = $_REQUEST['description'];
  $image = $_REQUEST['image'];
  $id_category = $_REQUEST['id_category'];
  $trailer = $_REQUEST['trailer'];
  $min_age = $_REQUEST['min_age'];

  $ok = addFilm($name, $director, $year, $length, $description, $id_category, $image, $trailer, $min_age);

  if ($ok) {
      return "$name a été ajouté avec succès !";
  } else {
      return "Erreur lors de l'ajout de $name !";
  }
}


function readMovieTrailerController() {
  if (!isset($_REQUEST['id'])) {
      return false; 
  }

  $id = intval($_REQUEST['id']);
  $movie = getMovieTrailer($id);

  if ($movie) {
      return $movie;
  } else {
      return false;
  }
  $movie->average_rating = getAverageRating($id);
}


function readMoviesByCategoryController() {
  $categories = getMoviesByCategory();
  return $categories ? $categories : false;
}


function addProfileController() {
  // Vérifie si tous les paramètres nécessaires sont présents
  $requiredFields = ['name', 'avatar', 'min_age'];
  $count = count($requiredFields);
  for ($i = 0; $i < $count; $i++) {
      $field = $requiredFields[$i];
      if (!isset($_REQUEST[$field])) {
          return "Erreur : Le champ '$field' est manquant.";
      }
  }

  // Récupère les données du formulaire
  $name = $_REQUEST['name'];
  $avatar = $_REQUEST['avatar'];
  $min_age = intval($_REQUEST['min_age']);

  // Appelle la fonction du modèle pour ajouter le profil
  $ok = addProfile($name, $avatar, $min_age);

  if ($ok) {
      return "$name a été ajouté avec succès !";
  } else {
      return "Erreur lors de l'ajout du profil $name !";
  }
}



function readProfilesController() {
  $profiles = getProfiles(); // Appel de la fonction du modèle
  if (!$profiles) {
    return ["error" => "Impossible de récupérer les profils."];
  }
  return $profiles;
}



function addFavoritesController() {
    if (!isset($_REQUEST['id_profile']) || !isset($_REQUEST['id_movie'])) {
        http_response_code(400); // Bad Request
        return ["error" => "Paramètres manquants : id_profile ou id_movie"];
    }

    $id_profile = intval($_REQUEST['id_profile']);
    $id_movie = intval($_REQUEST['id_movie']);

    if (isFavorites($id_profile, $id_movie)) {
        return ["message" => "Le film est déjà dans vos favoris."];
    }

    $ok = addFavorites($id_profile, $id_movie);
    if (!$ok) {
    }
    return $ok ? ["message" => "Le film a été ajouté à vos favoris."] : ["error" => "Erreur lors de l'ajout aux favoris."];
}

function getFavoritesController() {
  $id_profile = $_REQUEST['id_profile']; 
  return getFavorites($id_profile); 
}

function removeFavoritesController() {
  $id_profile = $_REQUEST['id_profile']; 
  $id_movie = $_REQUEST['id_movie'];
  $ok = removeFavorites($id_profile, $id_movie); 
  return $ok ? ["Le film a bien été retiré de vos favoris" => true] : ["error" => "Erreur lors de la suppression des favoris"];
}


function searchMoviesController() {
  // Récupération des paramètres de la requête
  $keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
  $category = isset($_REQUEST['category']) ? $_REQUEST['category'] : null;
  $year = isset($_REQUEST['year']) ? $_REQUEST['year'] : null;

  // Si aucun mot-clé n'est précisé, on renvoie une erreur
  if (empty($keyword)) {
      return ["error" => "Le titre du film est requis pour la recherche."];
  }

  // Recherche des films via le modèle
  $movies = searchMovies('%' . $keyword . '%', $category, $year);

  if ($movies === false) {
      return ["error" => "Une erreur est survenue lors de la recherche des films."];
  }

  if (empty($movies)) {
      return ["message" => "Aucun film ne correspond à votre recherche."];
  }

  return $movies;
}


function updateFeaturedStatusController() {
  if (!isset($_REQUEST['movie_id']) || !isset($_REQUEST['is_featured'])) {
      return false;
  }

  $movie_id = intval($_REQUEST['movie_id']);
  $is_featured = filter_var($_REQUEST['is_featured'], FILTER_VALIDATE_BOOLEAN);

  $result = updateFeaturedStatus($movie_id, $is_featured);
  return $result ? "Le statut du film a été mis à jour avec succès." : "Erreur lors de la mise à jour du statut.";
}

function addRatingController() { 
    if (!isset($_REQUEST['profile_id'], $_REQUEST['movie_id'], $_REQUEST['rating'])) {
        http_response_code(400);
        return ["error" => "Paramètres manquants : profile_id, movie_id ou rating"];
    }

    $profile_id = intval($_REQUEST['profile_id']);
    $movie_id = intval($_REQUEST['movie_id']);
    $rating = intval($_REQUEST['rating']);

    if ($profile_id <= 0 || $movie_id <= 0 || $rating < 1 || $rating > 10) {
        http_response_code(400);
        return ["error" => "Paramètres invalides"];
    }

    $ok = addRating($profile_id, $movie_id, $rating);
    return $ok ? ["message" => "Votre note a été enregistrée."] : ["error" => "Erreur lors de l'enregistrement de la note."];
}

function getAverageRatingController() {
  if (!isset($_REQUEST['movie_id'])) {
      return "Paramètre manquant : movie_id.";
  }

  $movie_id = $_REQUEST['movie_id'];
  return getAverageRating($movie_id);
}


function addCommentController() {
  if (!isset($_REQUEST['movie_id'], $_REQUEST['profile_id'], $_REQUEST['comment'])) {
      http_response_code(400); 
      return ["error" => "Paramètres manquants : movie_id, profile_id ou comment"];
  }

  $movie_id = intval($_REQUEST['movie_id']);
  $profile_id = intval($_REQUEST['profile_id']);
  $comment = trim($_REQUEST['comment']);

  if (empty($comment)) {
      return ["error" => "Le commentaire ne peut pas être vide."];
  }

  $ok = addComment($movie_id, $profile_id, $comment);
  return $ok ? ["message" => "Votre commentaire a été ajouté avec succès."] : ["error" => "Erreur lors de l'ajout du commentaire."];
}

function getCommentsController() {
  if (!isset($_REQUEST['movie_id'])) {
      http_response_code(400); 
      return ["error" => "Paramètre manquant : movie_id"];
  }

  $movie_id = intval($_REQUEST['movie_id']);
  $comments = getCommentsByMovie($movie_id);

  if (empty($comments)) {
      return ["message" => "Aucun commentaire pour ce film. Soyez le premier à en laisser un !"];
  }

  return $comments;
}

function getPendingCommentsController() {
    return getPendingComments();
}

function approveCommentController() {
    if (isset($_POST['comment_id'])) {
        $commentId = $_POST['comment_id'];
        return approveComment($commentId);
    }
    return false;
}

function deleteCommentController() {
    if (isset($_POST['comment_id'])) {
        $commentId = $_POST['comment_id'];
        return deleteComment($commentId);
    }
    return false;
}