let HOST_URL = "../server";

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=getAllMovies`);
  let data = await answer.json();
  return data;
}

DataMovie.requestFeaturedMovies = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=getFeaturedMovies`); 
  let data = await answer.json();
  return data;
};

DataMovie.addRating = async function (profileId, movieId, rating) {
  const url = `${HOST_URL}/script.php?todo=addRating&profile_id=${profileId}&movie_id=${movieId}&rating=${rating}`;
  console.log("URL:", url);
  let response = await fetch(url);

  if (!response.ok) {
    throw new Error(`Erreur serveur : ${response.status}`);
  }

  let jsonResponse = await response.json();
  if (jsonResponse.error) {
    throw new Error(jsonResponse.error);
  }

  return jsonResponse.message;
};

DataMovie.requestMovieTrailer = function (trailerId) {
  return fetch(`${HOST_URL}/script.php?todo=readMovieTrailer&id=${trailerId}`)
      .then(response => {
          if (!response.ok) {
              return Promise.reject('Erreur serveur');
          }
          return response.json();  
      })
      .then(data => data)  
      .catch(error => {
          console.error(error);
          return { error: "Une erreur est survenue lors de la récupération du trailer." }; 
      });
};


DataMovie.requestMoviesByCategory = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=readMovies`);
  let categories = await answer.json();
  return categories;
};

DataMovie.addFavorite = async function (movieId, profileId) {
  const url = `${HOST_URL}/script.php?todo=addFavorites&id_profile=${profileId}&id_movie=${movieId}`; 
  let answer = await fetch(url);
  if (!answer.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.getFavorite = async function (profileId) {
  const url = `${HOST_URL}/script.php?todo=getFavorites&id_profile=${profileId}`; 
  let answer = await fetch(url);
  let favoriteResponse = await answer.json();
  return favoriteResponse;
};

DataMovie.requestFeaturedMovies = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=getFeaturedMovies`);
  let data = await answer.json();
  return data;
};

DataMovie.searchMovies = async function (keyword, category = "", year = "") {
  const params = new URLSearchParams({
    keyword: keyword,
    category: category,
    year: year
  });

  const url = `${HOST_URL}/script.php?todo=searchMovies&${params.toString()}`;
  let answer = await fetch(url);
  if (!answer.ok) {
    throw new Error("Erreur lors de la requête au serveur.");
  }
  let searchResponse = await answer.json();
  return searchResponse;
};



export {DataMovie}
