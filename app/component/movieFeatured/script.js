let templateFile = await fetch("./component/movieFeatured/template.html");
let template = await templateFile.text();

let templateGridFile = await fetch("./component/movieFeatured/templateGrid.html");
let templateGrid = await templateGridFile.text();

let MovieFeatured = {};

MovieFeatured.formatOne = function (movie) {
  let movieHtml = template;
  movieHtml = movieHtml.replace("{{image}}", movie.image);
  movieHtml = movieHtml.replace("{{title}}", movie.name);
  movieHtml = movieHtml.replace("{{description}}", movie.description);
  movieHtml = movieHtml.replace("{{onclick}}", `C.handlerTrailer(${movie.id})`);
  return movieHtml;
};

MovieFeatured.formatGrid = function (movies) {
  if (movies.length === 0) {
    return "<p>Aucun film mis en avant pour le moment.</p>";
  }

  let formattedMovies = "";
  for (let movie of movies){
    formattedMovies += MovieFeatured.formatOne(movie);
  } 
  let gridHtml = templateGrid;
    gridHtml = gridHtml.replace("{{movies}}", formattedMovies);
  return gridHtml;
};

document.addEventListener("click", (e) => {
  if (e.target.classList.contains("carousel-nav")) {
    const direction = e.target.classList.contains("left") ? -1 : 1;
    const track = e.target.closest(".carousel-wrapper").querySelector(".carousel-track");
    const scrollAmount = 300;
    track.scrollBy({ left: scrollAmount * direction, behavior: "smooth" });
  }
});


export { MovieFeatured };
