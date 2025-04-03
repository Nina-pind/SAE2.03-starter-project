let HOST_URL = "https://mmi.unilim.fr/~pinardel2/SAE203-Nina";

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
  let data = await answer.json();
  return data;
}

export { DataMovie };