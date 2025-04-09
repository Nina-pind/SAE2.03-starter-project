let HOST_URL = "https://mmi.unilim.fr/~pinardel2/SAE2.03-Pinardel";

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let data = await answer.json();
  return data;
};

DataMovie.requestMovieTrailer = async function (trailerId) {
  let answer = await fetch(HOST_URL + `/server/script.php?todo=readMovieTrailer&id=${trailerId}`);
  let data = await answer.json();
  return data;
};

DataMovie.requestMoviesByCategory = async function (age) {
  const url = HOST_URL + "/server/script.php?todo=readMovies&age=" + age;
  let answer = await fetch(url);
  let categories = await answer.json();
  return categories;
};

// Ajoute un film aux favoris pour un profil donné
DataMovie.addFavorite = async function (profile_id, movie_id) {
  const url = `${HOST_URL}/server/script.php?todo=addFavorite&profile_id=${profile_id}&movie_id=${movie_id}`;
  console.log("URL générée pour l'ajout de favori :", url);

  try {
    let answer = await fetch(url);

    if (!answer.ok) {
      console.error(`Erreur HTTP : ${answer.status} ${answer.statusText}`);
      return { success: false, message: "Erreur lors de l'ajout du favori." };
    }

    let response = await answer.json();
    return response;
  } catch (error) {
    console.error("Erreur lors de la requête fetch :", error);
    return { success: false, message: "Erreur réseau ou serveur." };
  }
};

// Récupère la liste des favoris pour un profil donné
DataMovie.getFavorites = async function (profile_id) {
  const url = `${HOST_URL}/server/script.php?todo=getFavorites&profile_id=${profile_id}`;
  let response = await fetch(url);
  let favorites = await response.json();
  return Array.isArray(favorites) ? favorites : []; // Retourne un tableau vide si `favorites` n'est pas un tableau
};

export { DataMovie };