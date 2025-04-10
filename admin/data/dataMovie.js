let HOST_URL = "..";

let DataFilm = {}; 
let DataMovie = {}; 

DataFilm.requestFilms = async function () { 
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let data = await answer.json();
  return data;
};

DataFilm.addFilm = async function (formData) {
  let config = {
    method: "POST",
    body: formData,
  };
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addFilm", config );
  let data = await answer.json();
  return data;
};

DataMovie.searchMovies = async function (keyword) {
  const url = `${HOST_URL}/server/script.php?todo=searchMovies&keyword=${encodeURIComponent(keyword)}`;
  let answer = await fetch(url);
  let movies = await answer.json();
  return movies;
};

DataMovie.updateFeaturedStatus = async function (movieId, isFeatured) {
  const url = `${HOST_URL}/server/script.php?todo=updateFeaturedStatus&movie_id=${movieId}&is_featured=${isFeatured}`;
  console.log(`URL: ${url}`);
  let answer = await fetch(url);
  let response = await answer.json();
  return response;
};

export { DataFilm, DataMovie }; 