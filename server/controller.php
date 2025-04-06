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
}


function readMoviesByCategoryController() {
  $categories = getMoviesByCategory();
  return $categories ? $categories : false;
}


function addProfileController() {
  // Vérifie si tous les paramètres nécessaires sont présents
  $requiredFields = ['name', 'avatar', 'min_age'];
  foreach ($requiredFields as $field) {
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