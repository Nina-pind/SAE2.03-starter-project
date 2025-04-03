let HOST_URL = ".."

let DataMovie = {};

DataMovie.getMovies = async function() {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
  let data = await answer.json();
  return data;
}

export { DataMovie };