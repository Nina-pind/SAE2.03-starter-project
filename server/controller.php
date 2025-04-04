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


function addfilm (){
    $title = $_REQUEST['title'];
    $director = $_REQUEST['director'];
    $year = $_REQUEST['year'];
    $duration = $_REQUEST['duration'];
    $description = $_REQUEST['description'];
    $id_category = $_REQUEST['id_category'];
    $post = $_REQUEST['post'];
    $trailer = $_REQUEST['trailer'];
    $age_restriction = $_REQUEST['age_restriction'];

    $ok = addfilm($title, $director, $year, $duration, $description,$id_category, $post, $trailer, $age_restriction);
    if ($ok!=0){
      return "$title a été ajouté avec succès";
    }
    else{
      return "Le film n'a pas pu être ajouté";
}
    }