let HOST_URL = "..";

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let data = await answer.json();
  return data;
}

DataMovie.requestFeaturedMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getFeaturedMovies"); 
  let data = await answer.json();
  return data;
};

DataMovie.requestMovieTrailer = async function (trailerId) {
  let answer = await fetch(HOST_URL + `/server/script.php?todo=readMovieTrailer&id=${trailerId}`);
  let data = await answer.json();
  return data;
}

DataMovie.requestMoviesByCategory = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readMovies");
  let categories = await answer.json();
  return categories;
};

DataMovie.addFavorite = async function (movieId, profileId) {
  const url = `${HOST_URL}/server/script.php?todo=addFavorites&id_profile=${profileId}&id_movie=${movieId}`; 
  let answer = await fetch(url);
  if (!answer.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.getFavorite = async function (profileId) {
  const url = `${HOST_URL}/server/script.php?todo=getFavorites&id_profile=${profileId}`; 
  let answer = await fetch(url);
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.requestFeaturedMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getFeaturedMovies");
  let data = await answer.json();
  return data;
};

DataMovie.searchMovies = async function (keyword, category = "", year = "") {
  const params = new URLSearchParams({
    keyword: keyword,
    category: category,
    year: year
  });

  const url = `${HOST_URL}/server/script.php?todo=searchMovies&${params.toString()}`;
  let answer = await fetch(url);
  if (!answer.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  let searchResponse = await answer.json();
  return searchResponse;
};


export {DataMovie}
