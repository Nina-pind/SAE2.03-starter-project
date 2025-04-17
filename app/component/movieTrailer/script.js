let templateFile = await fetch("./component/movieTrailer/template.html");
let template = await templateFile.text();

let MovieTrailer = {};

MovieTrailer.format = function (movieData) {
  let html = template;
  html = html.replace(/{{movieTitle}}/g, movieData.name);
  html = html.replace("{{image}}", movieData.image);
  html = html.replace("{{movieSynopsis}}", movieData.description);
  html = html.replace("{{movieDirector}}", movieData.director);
  html = html.replace("{{movieYear}}", movieData.year);
  html = html.replace("{{movieCategory}}", movieData.category);
  html = html.replace("{{movieAgeRestriction}}", movieData.min_age);
  html = html.replace("{{movieTrailerUrl}}", movieData.trailer);
  html = html.replace("{{onclick}}", `C.addRating(${movieData.id})`);


  const isRecent = new Date(movieData.created_at) >= new Date(Date.now() - 7 * 24 * 60 * 60 * 1000);
  const newTag = isRecent ? '<span class="tag_new">New</span>' : '';
  html = html.replace("{{newTag}}", newTag); 

  let averageRating = movieData.average_rating || 0;
  html = html.replace("{{averageRating}}", averageRating);

  return html;
};

export { MovieTrailer };