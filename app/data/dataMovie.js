let HOST_URL = "https://mmi.unilim.fr/~pinardel2/SAE2.03-Pinardel";

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies");
  let data = await answer.json();
  return data;
}

DataMovie.requestMovieTrailer = async function (trailerId) {
  let answer = await fetch(HOST_URL + `/server/script.php?todo=readMovieTrailer&id=${trailerId}`);
  let data = await answer.json();
  return data;
}

DataMovie.requestMoviesByCategory = async function (age) {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=getAllMovies&age=" + age);
  let data = await answer.json();
  return data;
}


export {DataMovie}
