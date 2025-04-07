let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();


let Films = {};

Films.format = function (films ) {
  let html = "";
  console.log(films);
  films.forEach((film) => {
    let filmHtml = template;
    filmHtml = filmHtml.replace("{{titre}}", film.name);
    filmHtml = filmHtml.replace("{{image}}", film.image);
    filmHtml = filmHtml.replace("{{handler}}", `C.handlerTrailer(${film.id})`);
    html += filmHtml;
  });
  return html;
};

Films.formatLi = function (films) {
  let filmContent = Films.format(films); // Génère le HTML des films
  let liHtml = templateLi;
  liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
  return liHtml;
};
console.log(Films.formatLi([{ name: "Film 1", image: "image1.jpg", id: 1 }, { name: "Film 2", image: "image2.jpg", id: 2 }]));
export { Films };