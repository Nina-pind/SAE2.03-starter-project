let templateFile = await fetch("./component/movieTrailer/template.html");
let template = await templateFile.text();

let MovieTrailer = {};

MovieTrailer.format = function (movieData) {
  let html = template;
  html = html.replace(/{{movieTitle}}/g, movieData.name);
  html = html.replace("{{image}}", movieData.image);
  html = html.replace("{{movieSynopsis}}", movieData.description);
  html = html.replace("{{movieDirector}}", movieData.director);
  html = html.replace("{{movieYear}}", movieData.year );
  html = html.replace("{{movieCategory}}", movieData.category );
  html = html.replace("{{movieAgeRestriction}}", movieData.min_age);
  html = html.replace("{{movieTrailerUrl}}", movieData.trailer);
  console.log(html);
  return html;
};

export { MovieTrailer };