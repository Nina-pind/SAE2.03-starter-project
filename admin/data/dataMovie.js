let HOST_URL = "..";  // Définis l'URL correcte de ton serveur

let DataFilm = {};

// Fonction pour récupérer tous les films
DataFilm.requestFilms = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let data = await answer.json();
  return data;
};

// Fonction pour ajouter un film
DataFilm.addFilm = async function (formData) {
  let config = {
    method: "POST",
    body: formData,
  };
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addFilm", config);
  let data = await answer.json();
  return data;
};

// Fonction pour rechercher des films par mot-clé
DataFilm.searchMovies = async function (keyword) {
  const url = `${HOST_URL}/server/script.php?todo=searchMovies&keyword=${encodeURIComponent(keyword)}`;
  const response = await fetch(url);
  if (!response.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  return await response.json();
};

// Fonction pour mettre à jour le statut "mis en avant" d'un film
DataFilm.updateFeaturedStatus = async function (movieId, isFeatured) {
  const url = `${HOST_URL}/server/script.php?todo=updateFeaturedStatus&movie_id=${movieId}&is_featured=${isFeatured}`;
  let answer = await fetch(url);
  let response = await answer.json();
  return response;
};

export { DataFilm };
