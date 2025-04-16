import { Films } from "../film/script.js";

let templateFile = await fetch("./component/movieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (category) {
  let categoryHtml = template;
  categoryHtml = categoryHtml.replace("{{categoryName}}", category.name);
  categoryHtml = categoryHtml.replace("{{moviesList}}", Films.format(category.movies || []));

  // 🆕 Convertir le string HTML en élément DOM
  const wrapper = document.createElement("div");
  wrapper.innerHTML = categoryHtml.trim();
  return wrapper.firstChild;
};

export { MovieCategory };
