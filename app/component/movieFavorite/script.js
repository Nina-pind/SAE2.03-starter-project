let templateFile = await fetch("./component/movieFavorite/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/movieFavorite/template_li.html");
let templateLi = await templateLiFile.text();

let movieFavorite = {};

movieFavorite.format = function (favoriteData) {
  let html = template;


    html = html.replace("{{name}}", favoriteData.name);
    html = html.replace("{{image}}", favoriteData.image);
    html = html.replace(/{{id}}/g, favoriteData.id);
    html = html.replace("{{handler}}", `C.handlerTrailer(${favoriteData.id})`);

  return html;
};

movieFavorite.formatLi = function (favoriteData) {
  let favoriteContent = movieFavorite.format(favoriteData); 
  let liHtml = templateLi;
  liHtml = liHtml.replace("{{favorite}}", favoriteContent); 
  return liHtml;
};

export { movieFavorite };