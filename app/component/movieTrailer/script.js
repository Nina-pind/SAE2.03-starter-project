let templateFile = await fetch("./component/movieTrailer/template.html");
let template = await templateFile.text();

let MovieTrailer = {};

MovieTrailer.format = function (film) {
  let html = template;
  html = html.replace("{{movieTitle}}", film.name);
  html = html.replace("{{movieSynopsis}}", film.director);
  html = html.replace("{{movieDirector}}", film.year);
  html = html.replace("{{movieYear}}", film.description);
  html = html.replace("{{movieCategory}}", film.category);
  html = html.replace("{{movieAgeRestriction}}", film.min_age);
  html = html.replace("{{movieTrailerUrl}}", film.trailer);
  html = html.replace("{{image}}", film.image);
  return html;
};



export { MovieTrailer };




