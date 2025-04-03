let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movies) {
  let html = "";
  movies.forEach((movie) => {
    let movieHtml = template;
    movieHtml = movieHtml.replace("{{titre}}", movie.name);
    movieHtml = movieHtml.replace("{{image}}", movie.image);
    html += movieHtml;
  });
  return html;
};

export { Movie };